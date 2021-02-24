<?php

namespace App\Models;
use CodeIgniter\Model;

class ProductModel extends Model{
    protected $table = 'products';      //table
    protected $primaryKey = '_id';      //primaryKey ต้องตรงกับทุกๆๆ _id 
    protected $allowedFields = ['_id','name','category','price','tags']; //colum
}
?>