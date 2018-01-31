public function hierarchy()
	{
		// print_r($this->db->query()->result());
		// $parent = mysql_query("SELECT parent_id FROM menu WHERE id = '27'");
	   // var_dump($this->checkParentIds("30")) ;

		// $query=$this->db->query("select * from menu")->result();

		// var_dump($this->checkParentIds("30"));

		echo json_encode($this->getChilds("0"));
	}

	public function getChilds($id, array &$data =array())
	{
		$query=$this->db->query("select * from menu where parent_id='$id'")->result();

		$branch = array();

		foreach($query as $element)
		{
			// $q->childs=array();
			// $children=$this->getChilds($q->id, $q);
   //          if ( $children )
   //              $q->childs = $children;
			// $data[$q->id]=$q;
			// unset( $children );

			 $element->sub_categories=array();

            $children = $this->getChilds( $element->id, $query);
            if ( $children )
                $element->sub_categories = $children;

            // [$element->ID]

            $branch []= $element;
            unset( $element );

		}

		// if($query->parent_id>0)
		// {
		// 	$data[]=$query->parent_id;
		// 	$this->checkParentIds($query->parent_id, $data);
		// 	// var_dump($data);
		// }

		return ($branch);
	}

	public function checkParentIds($id, array &$data =array())
	{
		$query=$this->db->query("select parent_id from menu where id='$id'")->row();

		if($query->parent_id>0)
		{
			$data[]=$query->parent_id;
			$this->checkParentIds($query->parent_id, $data);
			// var_dump($data);
		}

		return ($data);
	}
