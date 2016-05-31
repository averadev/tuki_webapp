<?php 


class Xref_commerce_photos extends eloquent{ 

	protected $table = "xref_commerce_photos";
	public $timestamps = false;
	protected $SoftDelete = false;

	public function addNewGalleryPhotos($name){
		$this->idCommerce = Commerce::getCommerceID()->id;
		$this->image 	  = $name;
		if($this->save()){
			return true;
		}
		return false;
	}

	public function getAllGalleryPhotos(){
		$data = self::select('id','image')
		->where('idCommerce','=',Commerce::getCommerceID()->id)
		->get();
		return $data;
	}

	public function dropGalleryPhotos($id){
		$photo = $this->find($id);
		if($photo->delete()){
			return true;
		}
	}

}