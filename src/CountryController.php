<?php

namespace Tulparstudyo;
use App\Http\Controllers\Controller;
use Google\Exception;
use Illuminate\Http\Request;


class CountryController extends Controller
{
	function index(Request $request){
		return Response::success("Lütfen Giriş Yapınız");
	}
	function list(Request $request){
		if($rows = get_countries( $request->all() )){
			return Response::success("Ülke Bilgileri", $rows);
		}
		return Response::failure("Ülke Bulunamadı");
	}
	function get(Request $request, $id){
		if($row = get_country($id)){
			return Response::success("Ülke Bilgileri", $row);
		}
		return Response::failure("Ülke Bulunamadı");
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
			$row = create_country($fields);
			if($row){
				return Response::success("Ülke Oluşturuldu", $row);
			}
			return Response::failure("Ülke Oluşturulamadı");
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
			$row = update_country($id, $fields);
			if($row){
				return Response::success("Ülke Güncellendi", $row);
			}
			return Response::failure("Ülke Güncellenemedi");
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
			$row = Brand::where('id', $id)->get()->first();
			if($row){
				Brand::destroy($id);
				BrandDescription::where('brand_id', $id)->delete();
				return Response::success( "Ülke silindi", $row);
			} else {
				return Response::failure("Ülke Bulunamadı");
			}
			return BrandResponse::failure("Ülke Silinemedi");
		} catch(\Illuminate\Database\QueryException $ex){
			$exception = $ex->getMessage();
		} catch (Exception $ex){
			$exception = $ex->getMessage();
		}
		return Response::exception( '$exception');

	}
}
