<?php

namespace Tulparstudyo;
use App\Http\Controllers\Controller;
use Google\Exception;
use Illuminate\Http\Request;

class CityController extends Controller
{
	function index(Request $request){
		return Response::success("Lütfen Giriş Yapınız");
	}
	function list(Request $request, $country_id){
		if($rows = get_cities( $request->all(), $country_id)){
			return Response::success("Şehir Bilgileri", $rows);
		}
		return Response::failure("Şehir Bulunamadı");
	}
	function get(Request $request, $id){
		if($row = get_city($id)){
			return Response::success("Şehir Bilgileri", $row);
		}
		return Response::failure("Şehir Bulunamadı");
	}
	function post(Request $request) {
		$exception = '';
		try {
			$fields = $request->validate([
				'country_id' => 'required|numeric',
				'name'       => 'required|string|max:255',
				'code'       => 'required|string|max:32|unique:countries',
				'state'      => 'required|boolean'
			]);
			$row = create_city($fields);
			if($row){
				return Response::success("Şehir Oluşturuldu", $row);
			}
			return Response::failure("Şehir Oluşturulamadı");
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
				'country_id' => 'required|numeric',
				'name'       => 'required|string|max:255',
				'code'       => 'required|string|max:32|unique:brands',
				'sort_order' => 'required|integer',
				'state'      => 'required|boolean'
			]);
			$row = update_city($id, $fields);
			if($row){
				return Response::success("Şehir Güncellendi", $row);
			}
			return Response::failure("Şehir Güncellenemedi");
		} catch(\Illuminate\Database\QueryException $ex){
			$exception = $ex->getMessage();
		} catch (Exception $ex){
			$exception = $ex->getMessage();
		}
		return Response::exception( $exception );
	}
	function delete(Request $request, $id){
		$exception = '';
		try {
			if( $row = delete_city($id)){
				return Response::success("Şehir Silindi", $row);
			}
			return Response::failure("Şehir Bulunamadı");

		} catch(\Illuminate\Database\QueryException $ex){
			$exception = $ex->getMessage();
		} catch (Exception $ex){
			$exception = $ex->getMessage();
		}
		return Response::exception( $exception);
	}
}
