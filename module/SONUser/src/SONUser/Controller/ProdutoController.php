<?php

namespace SONUser\Controller;

use Zend\ProgressBar\ProgressBar;
use Zend\Loader\StandardAutoloader;
use Zend\Validator\AbstractValidator;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SONUser\Model\Produto;
use SONUser\Form\ProdutoForm;

class ProdutoController extends AbstractActionController {

    protected $produtoTable;

    public function getProdutoTable() {
        if (!$this->produtoTable) {
            $sm = $this->getServiceLocator();
            $this->produtoTable = $sm->get('produto-table');
        }
        return $this->produtoTable;
    }

    public function setMessagesLayout($messages) {
        $viewModel = $this->getEvent()->getViewModel();
        if (!$viewModel->getVariable('messages')) {
            $viewModel->setVariable('messages', $messages);
        }
    }

    public function indexAction() {
        $titulo = "Lista de produtos";
        $messages = $this->flashMessenger()->getMessages();
        $currentPage = $this->params()->fromQuery('pagina');
        $countPerPage = "5";
        $this->setMessagesLayout($messages);
        return new ViewModel(array(
            'titulo' => $titulo,
            'produtos' => $this->getProdutoTable()->fetchAll($currentPage, $countPerPage)
        ));
    }

    public function addAction() {
        $sm = $this->getEventManager();
        $translator = $this->getServiceLocator()->get('translator');
        AbstractValidator::setDefaultTranslator($translator);

        // instancia o formulário de produto
        $form = new ProdutoForm();
        $form->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Cadastrar'
            )
        ));

        // pega os dados postados
        $request = $this->getRequest();

        // Pega as fotos enviadas
        $File = $this->params()->fromFiles();

        // Conta a quantidade de fotos caso não seja enviada o padrão será 1
        $countFile = (count($File) > 0) ? count($File) : 1;

        // remove o campo produto_foto do formulário
        $form->remove('foto');

        // cria as novas fotos
        $fotosNew = array();

        // Faz a contagem das fotos e cria os campos no form com a quantidade criada
        for ($i = 1; $i <= $countFile; $i++) {
            // id da foto para gerar as fotos com os nomes foto_1, foto_2, etc.
            $fileId = $i;

            // gera o nome do campo da foto
            $file = 'foto_' . $fileId;

            // verifica se existe o campo foto gerada no loop, se existir seta no array fotosNew
            if (isset($File[$file]['name']) && $File[$file]['name'] != "") {
                $fotosNew[] = $File[$file]['name'];
            }

            // Instanciando a Factory para criar os input filter
            $factory = new Factory();

            // Adicionando o filtro campo do form
            $form->getInputFilter()->add($factory->createInput(array(
                        'name' => $file,
                        'required' => true,
                        'validators' => array(
                            array(
                                'name' => 'NotEmpty',
                                'options' => array(
                                    'messages' => array(
                                        'isEmpty' => 'Campo com o preenchimento obrigatório'
                                    )
                                )
                            )
                        )
            )));

            // Adicionando o campo no form
            $form->add(array(
                'name' => $file,
                'label' => 'Foto ' . $fileId,
                'attributes' => array(
                    'type' => 'file',
                    'name' => $file,
                    'class' => 'foto'
                )
            ));

            // Setando o label da foto no form
            $form->get($file)->setLabel('Foto ' . $fileId);
        }

        if ($request->isPost()) {
            // instanciando o model produto
            $produto = new Produto();

            // setando os campos para o input filter para validação
            $form->setInputFilter($produto->getInputFilter());

            $data = $request->getPost();
            $File = $this->params()->fromFiles('produto_foto');

            // Adicionando os campos recem criados na validação do form
            if ($File) {
                foreach ($File as $file => $info) {
                    $data->$file = $info['name'];
                }
            }

            // setando os valores vindos do post no form
            $form->setData($data);

            // submetendo a validação do formulario através do método isvalid
            if ($form->isValid()) {

                // upload arquivo
                $size = new \Zend\Validator\File\Size(array(
                    'max' => 2000000
                ));
                $adapter = new \Zend\File\Transfer\Adapter\Http();
                $adapter->setValidators(array($size));

                if (!$adapter->isValid()) {
                    $dataError = $adapter->getMessages();
                    $error = array();
                    foreach ($dataError as $key => $row) {
                        $error[] = $row;
                    }
                    $form->setMessages(array('produto_foto' => $error));
                } else {
                    $diretorio = $request->getServer('DOCUMENT_ROOT', false) . "\conteudos\produtos";
                    $adapter->setDestination($diretorio);

                    if ($adapter->receive()) {
                        
                    }
                }

                $produto->exchangeArray($request->getPost());
                $produto->produto_foto = json_encode($fotosNew);
                $this->getProdutoTable()->saveProduto($produto);

                return $this->redirect()->toUrl('/produto');
            }
        }

        $titulo = "Cadastro de produto";
        $view = new ViewModel(array(
            'titulo' => $titulo,
            'form' => $form,
            'countFile' => $countFile,
        ));
        $view->setTemplate('son-user/produto/form.phtml');

        return $view;
    }

    public function editarAction() {
        // pegando o id do produto passado via get
        $id = $this->params('id');
        // recuperando os dados do produto a ser editado
        $produto = $this->getProdutoTable()->getProduto($id);
        // instanciando o form
        $form = new ProdutoForm();
        $form->setBindOnValidate(false);
        $form->bind($produto);
        $form->get('submit')->setLabel('Alterar');
        // pegando os parametros passados via request
        $request = $this->getRequest();
        // Pega as fotos enviadas
        $File = $this->params()->fromFiles();
        // Conta a quantidade de fotos caso não seja enviada o padrão será 1
        $countFile = (count($File) > 0) ? count($File) : 1;
        // remove o campo produto_foto do formulário
        $form->remove('foto');
        // recupera do banco as fotos ja cadastradas caso existam
        $fotosOld = (array) json_decode($produto->produto_foto, true);
        // cria as novas fotos
        $fotosNew = array();
        // Faz a contagem das fotos e cria os campos no form com a quantidade criada
        for ($i = 1; $i <= $countFile; $i++) {
            // id da foto para gerar as fotos com os nomes foto_1, foto_2, etc.
            $fileId = $i;
            // gera o nome do campo da foto
            $file = 'foto_' . $fileId;
            // verifica se existe o campo foto gerada no loop, se existir seta no array fotosNew
            if (isset($File[$file]['name']) && $File[$file]['name'] != "") {
                $fotosNew[] = $File[$file]['name'];
            }
            // Instanciando a Factory para criar os input filter
            $factory = new Factory();
            // Adicionando o filtro campo do form
            $form->getInputFilter()->add($factory->createInput(array(
                        'name' => $file,
                        'required' => true,
                        'validators' => array(
                            array(
                                'name' => 'NotEmpty',
                                'options' => array(
                                    'messages' => array(
                                        'isEmpty' => 'Campo com o preenchimento obrigatório'
                                    )
                                )
                            )
                        )
            )));
            // Adicionando o campo no form
            $form->add(array(
                'name' => $file,
                'label' => 'Foto ' . $fileId,
                'attributes' => array(
                    'type' => 'file',
                    'name' => $file,
                    'class' => 'foto'
                )
            ));
            // Setando o label da foto no form
            $form->get($file)->setLabel('Foto ' . $fileId);
        }
        // verifica se o formulário foi postado
        if ($request->isPost()) {
            $data = $request->getPost();
            // Adicionando os campos recem criados na validação do form
            if ($File) {
                foreach ($File as $file => $info) {
                    $data->$file = $info['name'];
                }
            }
            // setando os dados no form para fazer a validação
            $form->setData($data);
            // validando o form com o isValid
            if ($form->isValid()) {
                $form->bindValues();
                $arrFotos = array_merge($fotosOld, $fotosNew);
                $produto->produto_foto = json_encode($arrFotos);
                // upload arquivo
                $size = new \Zend\Validator\File\Size(array(
                    'max' => 2000000
                ));
                $adapter = new \Zend\File\Transfer\Adapter\Http();
                $adapter->setValidators(array($size));
                // validando o upload das fotos 
                if (!$adapter->isValid()) {
                    foreach ($adapter->getMessages() as $indice => $row) {
                        $error[] = $row;
                    }
                    // adiciona as validações sempre após a ultima foto criada
                    $form->setMessages(array('foto_' . $countFile => $error));
                } else {
                    // setando o diretório para fazer o upload das fotos
                    $diretorio = $request->getServer('DOCUMENT_ROOT', false) . "\conteudos\produtos";
                    $adapter->setDestination($diretorio);
                    if ($adapter->receive()) {
                        
                    }
                }
                $this->getProdutoTable()->saveProduto($produto);
                $this->flashMessenger()->addMessage(array('success' => 'Produto atualizado com sucesso!'));
                $this->redirect()->toUrl('/produto');
            }
        }
        //exit(var_dump($fotosOld));
        $titulo = "Atualização de produto";
        $view = new ViewModel(array(
            'titulo' => $titulo,
            'form' => $form,
            'countFile' => $countFile,
            'fotos' => $fotosOld
        ));
        $view->setTemplate('son-user/produto/form.phtml');
        return $view;
    }

}
