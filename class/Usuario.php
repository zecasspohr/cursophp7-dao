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

        public static function getList() {
            $sql = new Sql();

            return $sql->select("SELECT * FROM TB_USUARIOS ORDER BY DESLOGIN");
        }

        public static function search($login) {

            $sql = new Sql();

            return $sql->select("SELECT * FROM TB_USUARIOS WHERE TB_USUARIOS.DESLOGIN LIKE :SEARCH ORDER BY DESLOGIN", array(
                        ":SEARCH" => "%" . $login . "%")
            );
        }

        public function login($login, $password) {
            $sql = new Sql();
            $result = $sql->select("SELECT * FROM TB_USUARIOS WHERE DESLOGIN = :LOGIN AND DESSENHA = :PASS", array(":LOGIN" => $login, ":PASS" => $password));

            if (count($result) > 0) {

                $this->setData($result[0]);
            } else {
                throw new Exception("Login ou senha inválido");
            }
        }

        public function setData($data) {
            $this->setIdusuario($data['idusuario']);
            $this->setDessenha($data['dessenha']);
            $this->setDesslogin($data['deslogin']);
            $this->setDtcadastro(new DateTime($data['dtcadastro']));
        }

        public function insert() {
            $sql = new Sql();

            $results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASS)", array(
                ":LOGIN" => $this->getDeslogin(),
                ":PASS" => $this->getDessenha()
            ));

            if (count($results) > 0) {
                $this->setData($results[0]);
            }
        }

        public function update($login, $pass) {

            if (isset($login)) {
                $this->setDesslogin($login);
            }
            if (isset($pass)) {
                $this->setDessenha($pass);
            }

            $sql = new Sql();
            $sql->query("UPDATE tb_usuarios SET deslogin=:LOGIN, dessenha=:PASS WHERE idusuario=:ID", array(
                ":LOGIN" => $this->getDeslogin(),
                ":PASS" => $this->getDessenha(),
                ":ID" => $this->getIdusuario()
            ));
        }

        public function delete() {

            $sql = new Sql();
            $sql->query("DELETE FROM tb_usuarios WHERE idusuario=:ID", array(
                ":ID" => $this->getIdusuario()
            ));
            
            $this->setIdusuario(0);
            $this->setDesslogin('');
            $this->setDessenha('');
            $this->setDtcadastro(new DateTime());
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
    