<?php
class MY_Model extends CI_Model
{
    protected $table;
    /**
    * fichier des modeles par defaut utilisables partout
    **/
    /**
    * function setData()
    * Ins�re une donn�e dans la table
    *
    * @param	$table	(string)	table consern�e
    * @param	$datas	(array)		tableau des valeurs � ajouter
    * @param $last_id : bool�en pour savoir si l'on souhaite r�cup�rer le dernier id ins�r�
    * @return bool si $last_id vaut FALSE sinon l'id du dernier enregistrement
    * r�sultant de l'insertion en bdd
    **/
    public function setData($table, $datas,$last_id=FALSE)
    {
        if(!empty($table) && !empty($datas))
        {
            $result = $this->db->insert($table, $datas);
            if($last_id == TRUE)
            {
                return $this->db->insert_id();
            }
            else
            {
                return TRUE;
            }
        }
        return FALSE;
    }
    /**
    * function setBatchData()
    * Ins�re plusieurs lignes simultan�es dans la table
    *
    * @param	$table	(string)	table consern�e
    * @param	$datas	(array)		tableau des valeurs � ajouter
    * @return bool
    **/
    public function setBatchData($table, $datas)
    {
        if(!empty($table) && !empty($datas))
        {
            $result = $this->db->insert_batch($table, $datas);
            return TRUE;
        }
        return FALSE;
    }
    /**
    * function updateData()
    * modifie un enregistrement dans la table
    *
    * @param	$table	(string)	table consern�e
    * @param	$datas	(array)		tableau des valeurs � modifier
    * @param	$idx	(array)		tableau de s�lection de la ligne � modifier
    *
    * @return	$return	(boolean)	TRUE / FALSE
    **/
    public function updateData($table, $datas, $idx)
    {
        if(!empty($table) && !empty($datas) && !empty($idx))
        {
            return $this->db->update($table, $datas, $idx);
        }
        else return FALSE;
    }
    /**
    * function getData()
    * liste les enregistrements dans la table
    *
    * @param	$table	(string)	table consern�e
    * @param	$datas	(array)		tableau des conditions de s�lection
    * @param	$select	(string)	colonnes � s�lectionner
    *
    * @return	$data	(array)		datas de la ligne s�lectionn�e
    **/
    public function getData($table, $datas = '', $select = '*')
    {
        $data = [];
        if( ! empty($table))
        {
            $this->db->select($select);
            $this->db->from($table);
            if(is_array($datas) || $datas != '')
            {
                $this->db->where($datas);
            }
            $result = $this->db->get()->result();
            if( ! empty($result))
            {
                $data = $result[0];
                return $data;
            }
            else
            {
                return FALSE;
            }
        }
    }
    /**
    * function getList()
    * liste les enregistrements de la table
    *
    * @param	$table	(string)	table consern�e
    * @param	$datas	(array)		tableau des conditions de s�lection
    * @param	$select	(string)	colonnes � s�lectionner
    *
    * @return	$list	(array)		liste des r�sultats
    **/
    public function getList($table, $datas = '', $select='*', $order = '', $limit = '', $group_by = '')
    {
        if(!empty($table))
        {
            $this->db->select($select);
            $this->db->from($table);
            if($datas != '' || is_array($datas))
            {
                $this->db->where($datas);
            }
            if($group_by != '')
            {
                $this->db->group_by($group_by);
            }
            if($order != '')
            {
                $this->db->order_by($order);
            }
            if($limit != '')
            {
                $this->db->limit($limit[0], $limit[1]);
            }
            return $this->db->get()->result();
        }
        else return FALSE;
    }
    /**
    * function getNbData()
    * Nombre d'enregistrements dans la table
    *
    * @param	$table	(string)	table consern�e
    * @param	$datas	(array)		tableau des conditions de s�lection
    *
    * @return	$nb		(int)		liste des r�sultats
    **/
    public function getNbData($table, $datas = '')
    {
        if(!empty($table))
        {
            if(is_array($datas) || $datas != '')
            {
                $this->db->where($datas);
            }
            $this->db->from($table);
            return $this->db->count_all_results();
        }
        else return FALSE;
    }
    /**
    * function deleteData()
    * supprime un ou plusieurs enregistrements dans la table
    *
    * @param	$table	(string)	table consern�e
    * @param	$datas	(array)		tableau des conditions de suppression
    *
    * @return	$return	(boolean)	TRUE / FALSE
    **/
    public function deleteData($table, $datas)
    {
        if(!empty($table) && !empty($datas))
        {
            $this->db->where($datas);
            return $this->db->delete($table);
        }
        else return FALSE;
    }
    /**
    * function deleteMultiplesDatas()
    * supprime un ou plusieurs enregistrements dans la table
    *
    * @param	$table	(string)	table consern�e
    * @param	$column	(array)		colonne point�e pour la suppression
    * @param	$datas	(array)		tableau des donn�es � supprimer
    *
    * @return	$return	(boolean)	TRUE / FALSE
    **/
    public function deleteMultiplesDatas($table, $column, $datas)
    {
        if(!empty($table) && !empty($datas)&&(!empty($column)))
        {
            if(!is_array($datas))$datas = (array)$datas;
            $this->db->where_in($column,$datas);
            return $this->db->delete($table);
        }
        else return FALSE;
    }
    /**
    * function is_unique_data()
    * V�rifie l'unicit� d'une donn�e
    *
    * @param $data : la donn�e � v�rifier
    * @param $table : la table dans laquelle il faut effectuer la v�rification
    *
    * @return bool TRUE si la donn�e n'existe pas dans la table
    */
    public function is_unique_data($table,$data)
    {
        $check = $this->getData($table, $data);
        if($check === FALSE)
        {
            return TRUE;
        }
        return FALSE;
    }
    /**
    * function getSum()
    * effectue la somme de la colonne cibl�e
    *
    * @param	$table	(string)	table consern�e
    * @param	$col	(string)	colonne � additionner
    * @param	$datas	(array)		tableau des conditions de s�lection
    *
    * @return	$data	(array)		datas de la ligne s�lectionn�e
    **/
    public function getSum($table, $col, $datas = '')
    {
        if(!empty($table))
        {
            $this->db->select_sum($col);
            if($datas != '')
            $this->db->where($datas);
            $result = $this->db->get($table)->result();
            return $result[0]->$col;
        }
        return false;
    }
}
