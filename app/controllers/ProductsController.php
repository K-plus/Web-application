<?php

use Kplus\Transformers\ProductTransformer;

/**
 * Class ProductsController
 */
class ProductsController extends ApiController {

    /**
     * @var Kplus\Transformers\ProductTransformer
     */
    protected $productTransformer;

    /**
     * @param ProductTransformer $productTransformer
     */
    function __construct(ProductTransformer $productTransformer)
    {
        $this->productTransformer = $productTransformer;

        $this->beforeFilter('auth.basic', ['on' => 'post']);

    }


    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$products =  Product::all();
		return $this->respond([
            'data' => $this->productTransformer->transformCollection($products->all())
        ]);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if( ! Input::get('name'))
        {
            return $this->respondValidationError('Parameters failed validation for a product.');
        }

        Product::create(Input::all());

        return $this->respondCreated('Product succesfully created.');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$product = Product::find($id);

		if( ! $product){
            return $this->respondNotFound('Product does not exist');
		}

		return $this->respond([
			'data' => $this->productTransformer->transform($product)
		]);

	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
