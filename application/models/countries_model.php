<?php
    /**
     * Created by John Huseinovic
     * Date: 15/11/12
     * Time: 5:07 PM
     */
class Countries_model extends MY_Model
{

    function getCountriesProducts( &$host, $document_root="" )
    {
        $this->db->select('hp.pid, p.name as ProductName, c.name as CountryName, concat(c.iso,hp.cnum) as Country', false);
        $this->db->where('hid', $host->id);
        $this->db->where('hp.cnum = 0');
        $this->db->from('hosts_products hp');
        $this->db->join('countries c', 'hp.cid=c.id');
        $this->db->join('products p', 'hp.pid=p.path');
        $this->db->order_by('c.name, p.name');
        $query = $this->db->get();

        if( $query->num_rows() == 0 )
            show_error("There are no countries / products configured!");


        $data = array();
        $data['Countries'] =  array();

        $results = $query->result();

        foreach($results as $rs)
        {

            if( !isset($data['Countries'][$rs->Country]) )
                $data['Countries'][$rs->Country] = array();

            $data['Countries'][$rs->Country]['name'] = $rs->CountryName;

            if( !isset($data['Countries'][$rs->Country]['products']) )
                $data['Countries'][$rs->Country]['products'] = array();


            if($rs->pid == "portal")
            {
            $data['Countries'][$rs->Country]['products']['portalgames'] = array('name'=>'Games', 'url'=>"{$document_root}/portal/contenthome/{$rs->Country}/join/games");
            $data['Countries'][$rs->Country]['products']['portalvideos'] = array('name'=>'Videos', 'url'=>"{$document_root}/portal/contenthome/{$rs->Country}/join/videos");
            $data['Countries'][$rs->Country]['products']['portalwalls'] = array('name'=>'Wallpapers', 'url'=>"{$document_root}/portal/contenthome/{$rs->Country}/join/wallpapers");
            $data['Countries'][$rs->Country]['products']['portaltones'] = array('name'=>'Tones', 'url'=>"{$document_root}/portal/contenthome/{$rs->Country}/join/tones");
            $data['Countries'][$rs->Country]['products']['portalanim'] = array('name'=>'Animations', 'url'=>"{$document_root}/portal/contenthome/{$rs->Country}/join/animations");
            }

            elseif($rs->pid == "orangeportal")
            {
                $data['Countries'][$rs->Country]['products']['home'] = array('name'=>'Home', 'url'=>"{$document_root}/mobilemojo/index/{$rs->Country}/club/Home");
                $data['Countries'][$rs->Country]['products']['videos'] = array('name'=>'Videos', 'url'=>"{$document_root}/mobilemojo/content/{$rs->Country}/club/Videos");
                $data['Countries'][$rs->Country]['products']['games'] = array('name'=>'Games', 'url'=>"{$document_root}/mobilemojo/content/{$rs->Country}/club/Games");
                $data['Countries'][$rs->Country]['products']['music'] = array('name'=>'Music', 'url'=>"{$document_root}/mobilemojo/content/{$rs->Country}/club/Music");


            }
            else
            {
               // $data['Countries'][$rs->Country]['products'][$rs->pid] = array();
               // $data['Countries'][$rs->Country]['products'][$rs->pid]['name'] = $rs->ProductName;
               // $data['Countries'][$rs->Country]['products'][$rs->pid]['url'] = "{$document_root}/{$rs->pid}/index/{$rs->Country}/gen";
            }
        }

        return $data['Countries'];

    }
}