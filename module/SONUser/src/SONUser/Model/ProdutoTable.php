<?php

namespace SONUser\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\AbstractTableGateway;

class ProdutoTable extends AbstractTableGateway {

    protected $table = 'tbl_produtos';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Produto());
        $this->initialize();
    }

    public function fetchAll($currentPage = 1, $countPerPage = 2) {
        $select = new Select();
        $select->from($this->table)->order('produto_id');
        $adapter = new \Zend\Paginator\Adapter\DbSelect($select, $this->adapter, $this->resultSetPrototype);
        $paginator = new \Zend\Paginator\Paginator($adapter);
        $paginator->setItemCountPerPage($countPerPage);
        $paginator->setCurrentPageNumber($currentPage);
        return $paginator;
    }

    public function getProduto($id) {
        $id = (int) $id;
        $rowset = $this->select(array('produto_id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Registro $id não encontrado!");
        }
        return $row;
    }

    public function saveProduto(Produto $produto) {
        $data = array(
            'produto_nome' => $produto->produto_nome,
            'produto_preco' => $produto->produto_preco,
            'produto_foto' => $produto->produto_foto,
            'produto_descricao' => $produto->produto_descricao,
            'produto_status' => $produto->produto_status
        );
        $id = (int) $produto->produto_id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getProduto($id)) {
                $this->update($data, array('produto_id' => $id));
            } else {
                throw new \Exception("Registro $id não encontrado!");
            }
        }
    }

    public function deleteProduto($id) {
        $id = (int) $id;
        if ($this->getProduto($id)) {
            $this->delete(array('produto_id' => $id));
        } else {
            throw new \Exception("Registro $id não encontrado!");
        }
    }

}

?> 