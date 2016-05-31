<?php
/**
* Clase para los colores que identifican al comercio
*/
class Palette extends Eloquent
{
	protected $table = "palette";
	protected $SoftDelete = false;

	public function getMyPaletteColors(){		
		$data = [];
		$colors = self::select('id','name','bg1 as R','bg2 as G','bg3 as B')
				->get();
		foreach ($colors as $key => $value) {
			$hexColors = new stdClass();
			$colorCommerce = array($value->R,$value->G,$value->B);
			$hexColors->code = Helper::rgb2hex($colorCommerce);
			$hexColors->name = $value->name;
			$hexColors->id 	 = $value->id;
			array_push($data, $hexColors);
		}
		return $data;
	}

} /*End model*/