<?php
interface DAO {
    public function delete($classe_metier);
    public function find($tableau);
    public function persist($classe_metier);
    public function update($classe_metier);
}
?>