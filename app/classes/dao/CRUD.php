<?php
interface CRUD {
    public function create($classe_metier);
    public function read($tableau);
    public function update($classe_metier);
    public function delete($tableau);
}
?>