<?php
  if (defined('_CAMPAIGN_CLASS_INCLUDED_'))
    return;
  define ('_CAMPAIGN_CLASS_INCLUDED_', true, true);

  require('db.php');
  require(dirname(__FILE__) . '/../system.php');

  class Site
  {

    var $totalCharacters;
    var $charsPerTemplate = array();

    var $publicCharacters;
    var $totalUsers;

    var $averageCharactersPerUser = 0;

    var $totalCampaigns;
    var $charactersInCampaigns;
    var $averageCharactersPerCampaign = 0;

    var $activeCampaigns;
    var $openCampaigns;

    function Site()
    {
      global $TABLE_CAMPAIGNS, $TABLE_CHARS, $TABLE_TEMPLATES, $TABLE_USERS;

      $this->totalCharacters = $this->GetCount("select count(*) from " . $TABLE_CHARS);

      $this->publicCharacters = $this->GetCount("select count(*) from " . $TABLE_CHARS . " where public = 'y'");
      $this->totalUsers = $this->GetCount("select count(*) from " . $TABLE_USERS);

      $this->totalCampaigns = $this->GetCount("select count(*) from " . $TABLE_CAMPAIGNS);
      $this->charactersInCampaigns = $this->GetCount("select count(*) from " . $TABLE_CHARS . " where campaign is not null");

      $this->activeCampaigns = $this->GetCount("select count(*) from " . $TABLE_CAMPAIGNS . " where active = 'Y'");
      $this->openCampaigns = $this->GetCount("select count(*) from " . $TABLE_CAMPAIGNS . " where open = 'Y'");

      $this->charsPerTemplate = array();
      $res = mysql_query("select st.name, count(c.id) from ".
                         $TABLE_TEMPLATES . " st, ".
                         $TABLE_CHARS . " c where c.template_id = st.id group by st.id");
      if( $res ) {
        while ($row = mysql_fetch_row($res)) {
          array_push($this->charsPerTemplate, array('template' => $row[0], 'count' => $row[1]));
        }
      }

      if( $this->totalUsers > 0 ) { 
        $ave = $this->totalCharacters / $this->totalUsers;
        $this->averageCharactersPerUser = sprintf("%3.2f", $ave);
      }

      if( $this->totalCampaigns > 0 ) {
        $ave = $this->charactersInCampaigns / $this->totalCampaigns;
        $this->averageCharactersPerCampaign = sprintf("%3.2f", $ave);
      }

    }

    function GetCount($sql) {
      
      $res = mysql_query($sql);

      if( ! $res ) {
        return 0;
      }

      $row = mysql_fetch_row($res);

      return (int) $row[0];
    }


    // Save character data to the db. $sid must be a session id for the
    // user who is editing the character. Return true on success.
    function Save()
    {
      global $TABLE_CAMPAIGNS;

      // Update the db.
      $res = mysql_query(sprintf("UPDATE %s SET name = '%s', active = '%s', open = '%s', website = '%s', ".
                                 "pc_level = '%s', max_players = %d, pc_alignment = '%s', description = '%s' ".
                                 "WHERE id = %d LIMIT 1",
        $TABLE_CAMPAIGNS,
        addslashes($this->cname),
        $this->active ? 'Y' : 'N',
        $this->open ? 'Y' : 'N',
        addslashes($this->website),
        addslashes($this->pc_level),
        (int) $this->max_players,
        addslashes($this->pc_alignment),
        addslashes($this->desc),
        (int) $this->id));

      return $res ? true : false;
    }
  }
?>
