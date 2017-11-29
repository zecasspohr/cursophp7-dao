<?php

    class Usuario {
        private $idusuario;
        private $desslogin;
        private $dessenha;
        private $dtcadastro;
        function getIdusuario() {
            return $this->idusuario;
        }

        function getDeslogin() {
            return $this->desslogin;
        }

        function getDessenha() {
            return $this->dessenha;
        }

        function getDtcadastro() {
            return $this->dtcadastro;
        }

        function setIdusuario($idusuario) {
            $this->idusuario = $idusuario;
        }

        function setDesslogin($desslogin) {
            $this->desslogin = $desslogin;
        }

        function setDessenha($dessenha) {
            $this->dessenha = $dessenha;
        }

        function setDtcadastro($dtcadastro) {
            $this->dtcadastro = $dtcadastro;
        }

        public function loadById($id) {

            $sql = new Sql();
            $result = $sql->select("SELECT * FROM TB_USUARIOS WHERE IDUSUARIO = :ID", array(":ID" => $id));

            if (isset($result[0])) {
                $row = $result[0];

                $this->setIdusuario($row['idusuario']);
                $this->setDessenha($row['dessenha']);
                $this->setDesslogin($row['deslogin']);
                $this->setDtcadastro(new DateTime($row['dtcadastro']));
            }
        }

        function __toString() {
            return json_encode(array(
                "idusuario" => $this->getIdusuario(),
                "deslogin" => $this->getDeslogin(),
                "dessenha" => $this->getDessenha(),
                "dtcadastro" => $this->getDtcadastro()->format("d/m/Y h:i:s")
            ));
        }

    }
    