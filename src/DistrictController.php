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
	function list(Request $request, $city_id){
		if($rows = get_districts( $request->all(), $city_id)){
			return Response::success("İlçe Bilgileri", $rows);
		}
		return Response::failure("İlçe Bulunamadı");
	}
	function get(Request $request, $id){
		if($row = get_district($id)){
			return Response::success("İlçe Bilgileri", $row);
		}
		return Response::failure("İlçe Bulunamadı");
	}
	function post(Request $request) {
		$exception = '';
		try {
			$fields = $request->validate([
				'city_id'    => 'required|numeric',
				'name'       => 'required|string|max:255',
				'code'       => 'required|string|max:32|unique:countries',
				'state'      => 'required|boolean'
			]);
			$row = create_district($fields);
			if($row){
				return Response::success("İlçe Oluşturuldu", $row);
			}
			return Response::failure("İlçe Oluşturulamadı");
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
				'city_id'    => 'required|numeric',
				'name'       => 'required|string|max:255',
				'code'       => 'required|string|max:32|unique:brands',
				'sort_order' => 'required|integer',
				'state'      => 'required|boolean'
			]);
			$row = update_district($id, $fields);
			if($row){
				return Response::success("İlçe Güncellendi", $row);
			}
			return Response::failure("İlçe Güncellenemedi");
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
			if( $row = delete_district($id)){
				return Response::success("İlçe Silindi", $row);
			}
			return Response::failure("İlçe Bulunamadı");

		} catch(\Illuminate\Database\QueryException $ex){
			$exception = $ex->getMessage();
		} catch (Exception $ex){
			$exception = $ex->getMessage();
		}
		return Response::exception( $exception);
	}
}
