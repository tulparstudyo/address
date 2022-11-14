<?php

namespace Tulparstudyo;
use App\Http\Controllers\Controller;
use Google\Exception;
use Illuminate\Http\Request;


class DistrictController extends Controller
{
	function index(Request $request){
		return Response::success("Lütfen Giriş Yapınız");
	}
	function list(Request $request){
		if($brands = get_brands( $request->all() )){
			return Response::success("Marka Bilgileri", $brands);
		}
		return Response::failure("Marka Bulunamdı");
	}
	function get(Request $request, $id){
		if($brand = get_brand($id)){
			return Response::success("Marka Bilgileri", $brand);
		}
		return Response::failure("Marka Bulunamdı");
	}
	function post(Request $request) {
		$exception = '';
		try {
			$fields = $request->validate([
				'name'       => 'required|string|max:255',
				'code'       => 'required|string|max:32|unique:brands',
				'rate'       => 'required|integer',
				'sort_order' => 'required|integer',
				'state'      => 'required|boolean'
			]);
			$brand = create_brand($fields);
			if($brand){
				return Response::success("Marka Oluşturuldu", $brand);
			}
			return Response::failure("Marka Oluşturulamadı");
		} catch(\Illuminate\Database\QueryException $ex){
			$exception = $ex->getMessage();
		} catch (Exception $ex){
			$exception = $ex->getMessage();
		}
		return Response::exception( $exception);
	}
	function put(Request $request, $id){
		$exception = '';
		try {
			$fields = $request->validate([
				'name'       => 'required|string|max:255',
				'code'       => 'required|string|max:32|unique:brands',
				'rate'       => 'required|integer',
				'sort_order' => 'required|integer',
				'state'      => 'required|boolean'
			]);
			$brand = update_brand($id, $fields);
			if($brand){
				return Response::success("Marka Güncellendi", $brand);
			}
			return Response::failure("Marka Güncellenemedi");
		} catch(\Illuminate\Database\QueryException $ex){
			$exception = $ex->getMessage();
		} catch (Exception $ex){
			$exception = $ex->getMessage();
		}
		return Response::exception( '$exception');
	}
	function delete(Request $request, $id){
		$exception = '';
		try {
			$brand = Brand::where('id', $id)->get()->first();
			if($brand){
				Brand::destroy($id);
				BrandDescription::where('brand_id', $id)->delete();
				return Response::success( "Marka silindi", $brand);
			} else {
				return Response::failure("Marka Bulunamadı");
			}
			return BrandResponse::failure("Marka Silinemedi");
		} catch(\Illuminate\Database\QueryException $ex){
			$exception = $ex->getMessage();
		} catch (Exception $ex){
			$exception = $ex->getMessage();
		}
		return Response::exception( '$exception');

	}
}
