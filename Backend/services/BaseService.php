<?php
require_once __DIR__ . '/../dao/baseDao.php';

class BaseService {
   protected $dao;
   public function __construct(BaseDao $dao) {
       $this->dao = $dao;
   }
   public function getAll() {
       return $this->dao->getAll();
   }

   public function add($entity)
    {
        return $this->dao->add($entity);
    }
    
   public function getById($id) {
       return $this->dao->getById($id);
   }
   public function create($data) {
       return $this->dao->insert($data);
   }
   public function update($id, $data) {
       return $this->dao->update($id, $data);
   }
   public function delete($id) {
       return $this->dao->delete($id);
   }
}
?>
