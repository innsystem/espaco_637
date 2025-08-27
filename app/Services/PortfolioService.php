<?php

namespace App\Services;

use App\Models\Portfolio;
use App\Models\PortfolioImage;
use App\Models\Category;

class PortfolioService
{
	public function getAllPortfolios($filters = [], $paginate = false, $perPage = 10)
	{
		$query = Portfolio::with(['category', 'images' => function($query) {
			$query->orderBy('sort_order', 'asc');
		}]);

		if (!empty($filters['name'])) {
			$query->where('title', 'LIKE', '%' . $filters['name'] . '%');
		}

		if (!empty($filters['status'])) {
			$query->where('status', $filters['status']);
		}

		if (!empty($filters['category_id'])) {
			$query->where('category_id', $filters['category_id']);
		}

		if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
			$query->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
		}

		$query->ordered();

		if ($paginate) {
			return $query->paginate($perPage);
		}

		return $query->get();
	}

	public function getPortfoliosByCategory($categoryId = null)
	{
		$query = Portfolio::with(['category', 'images' => function($query) {
			$query->orderBy('sort_order', 'asc');
		}])->active();
		
		if ($categoryId) {
			$query->where('category_id', $categoryId);
		}

		return $query->ordered()->get();
	}

	public function getPortfolioById($id)
	{
		return Portfolio::with(['category', 'images' => function($query) {
			$query->orderBy('sort_order', 'asc');
		}])->findOrFail($id);
	}

	public function createPortfolio($data)
	{
		return Portfolio::create($data);
	}

	public function updatePortfolio($id, $data)
	{
		$model = Portfolio::findOrFail($id);
		$model->update($data);
		return $model;
	}

	public function deletePortfolio($id)
	{
		$model = Portfolio::findOrFail($id);
		return $model->delete();
	}

	public function deleteImagePortfolio($image_id)
	{
		$model = PortfolioImage::findOrFail($image_id);

		// Verifica se a imagem atual é a destacada
		if ($model->featured == 1) {
			// Busca a próxima imagem que não seja a atual
			$portfolio_image_next = PortfolioImage::where('portfolio_id', $model->portfolio_id)
				->where('id', '!=', $model->id)
				->first();

			// Define a próxima imagem como destacada, se existir
			if ($portfolio_image_next) {
				$portfolio_image_next->featured = 1;
				$portfolio_image_next->save();
			}
		}

		// Após tratar o destaque, exclua a imagem atual
		return $model->delete();
	}

	public function updateImageOrder($imageId, $newOrder)
	{
		$image = PortfolioImage::findOrFail($imageId);
		$image->sort_order = $newOrder;
		return $image->save();
	}

	public function reorderImages($portfolioId, $imageOrders)
	{
		// Validate that all images belong to the portfolio
		$portfolioImages = PortfolioImage::where('portfolio_id', $portfolioId)
			->whereIn('id', $imageOrders)
			->pluck('id')
			->toArray();
		
		if (count($portfolioImages) !== count($imageOrders)) {
			return false;
		}
		
		// Use a transaction to ensure data consistency
		\DB::transaction(function() use ($portfolioId, $imageOrders) {
			// Update sort_order for each image using DB facade for direct SQL
			foreach ($imageOrders as $order => $imageId) {
				\DB::table('portfolio_images')
					->where('id', $imageId)
					->where('portfolio_id', $portfolioId)
					->update(['sort_order' => $order]);
			}
		});
		
		// Clear any cache and return true
		\Cache::forget("portfolio_{$portfolioId}_images");
		return true;
	}

	public function getAllCategories()
	{
		return Category::active()->ordered()->get();
	}
}
