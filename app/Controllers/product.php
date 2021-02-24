<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ProductModel;

class Product extends ResourceController{
    use ResponseTrait; 

    //get all products
    public function index()
    {
        $model = new ProductModel();
        $data['products'] = $model->orderBy('_id', 'DESC')->findAll();
        return $this->respond($data); 
    }

    //get product by Id
    public function getProduct($id=null){
        $model = new ProductModel();
        $data = $model->where('_id', $id)->first();   //ค้นหาแถวแรก
        if($data){
            return $this->respond($data);              //เจอจะรีเทรินค่าออกมา
        }
        else{
            return $this->failNotFound('No product found'); //ถ้าไม่เจอจะเป้นผิด
        }
    }

    //insert
    public function create(){
        $model = new ProductModel();        //insert ข้อมูลเข้า
        $data=[
            "name"=>$this->request->getVar('name'),
            "category"=>$this->request->getVar('category'),
            "price"=>$this->request->getVar('price'),
            "tags"=>$this->request->getVar('tags')

        ];
        $model->insert($data);      //เวลาเข้าแล้วจะขึ้นโชว์แบบข้างล่างเปิดดูใน postman ได้
        $response=[
            'status'=>201,          //  
            'error'=>null,          //
            "message"=>[
                'success' => 'Product created success'
            ]
        ];
        return $this->respond($response);
    }

    //update
    public function update($id = null)              //อัปเดทข้อมูล
    {
        $model = new ProductModel();
        $data=[
            "name"=>$this->request->getVar('name'),
            "category"=>$this->request->getVar('category'),
            "price"=>$this->request->getVar('price'),
            "tags"=>$this->request->getVar('tags')

        ];
        //$model->where("_id", $id)->set($data)->update;  ///อัปเดตแบบไม่ใช่ pramilykey
        $model->update($id, $data);     //อัปเดตที่ไอดีที่เราเลือก 
        $response=[
            'status'=>201,
            'error'=>null,
            "message"=>[
                'success' => 'Product update success'
            ]
        ];
        return $this->respond($response);
    }


    //delete
    public function delete($id = null)
    {
        $model = new ProductModel();
        $data = $model->find($id);     //ลบที่ไอดีที่เราเลือก 
       if ($data) {
           $model->delete($id);
           $response = [
               'status' => 200,
               'error' => null,
               "message" => [
                   'success' => 'Product delete successfully'
               ]
            ];
            return $this->respond($response);
       } else {
           return $this->failNotFound('No product found');
       }
    }
}
?>