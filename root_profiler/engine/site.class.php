<?php
  if (defined('_CAMPAIGN_CLASS_INCLUDED_'))
    return;
  define ('_CAMPAIGN_CLASS_INCLUDED_', true, true);

  require_once('db.php');
  require_once(dirname(__FILE__) . '/../system.php');

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

    public function __construct()
    {
      global $TABLE_CAMPAIGNS, $TABLE_CHARS, $TABLE_TEMPLATES, $TABLE_USERS, $rpgDB, $DISPLAY_STATS;

      if( $DISPLAY_STATS ) {
		  $this->totalCharacters = $this->GetCount("select count(*) as cnt from " . $TABLE_CHARS);

		  $this->publicCharacters = $this->GetCount("select count(*) as cnt from " . $TABLE_CHARS . " where public = 'y'");
		  $this->totalUsers = $this->GetCount("select count(*) as cnt from " . $TABLE_USERS);

		  $this->totalCampaigns = $this->GetCount("select count(*) as cnt from " . $TABLE_CAMPAIGNS);
		  $this->charactersInCampaigns = $this->GetCount("select count(*) as cnt from " . $TABLE_CHARS . " where campaign is not null");

		  $this->activeCampaigns = $this->GetCount("select count(*) as cnt from " . $TABLE_CAMPAIGNS . " where active = 'Y'");
		  $this->openCampaigns = $this->GetCount("select count(*) as cnt from " . $TABLE_CAMPAIGNS . " where open = 'Y'");

		  $this->charsPerTemplate = array();
		  $res = $rpgDB->query("select st.name, count(c.id) as cnt from ".
							 $TABLE_TEMPLATES . " st, ".
							 $TABLE_CHARS . " c where c.template_id = st.id group by st.id");
		  if( $res ) {
			while ($row = $rpgDB->fetch_row($res)) {
			  array_push($this->charsPerTemplate, array('template' => $row['name'], 'count' => $row['cnt']));
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

    }
    function Site()
    {
        self::__construct();
    }

    function GetCount($sql) {

      global $rpgDB;

      $res = $rpgDB->query($sql);

      if( ! $res ) {
        return 0;
      }

      $row = $rpgDB->fetch_row($res);

      return (int) $row['cnt'];
    }


    // Save character data to the db. $sid must be a session id for the
    // user who is editing the character. Return true on success.
    function Save()
    {
      global $TABLE_CAMPAIGNS, $rpgDB;

      // Update the db.
      $res = $rpgDB->query(sprintf("UPDATE %s SET name = %s, active = '%s', open = '%s', website = %s, ".
                                 "pc_level = %s, max_players = %d, pc_alignment = %s, description = %s ".
                                 "WHERE id = %d",
        $TABLE_CAMPAIGNS,
        $rpgDB->quote($this->cname),
        $this->active ? 'Y' : 'N',
        $this->open ? 'Y' : 'N',
        $rpgDB->quote($this->website),
        $rpgDB->quote($this->pc_level),
        (int) $this->max_players,
        $rpgDB->quote($this->pc_alignment),
        $rpgDB->quote($this->desc),
        (int) $this->id));

      return $res ? true : false;
    }
  }
?>
