<?php

/*
 * OrgPostList.php
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
*/
class OrgPostList {
    public $Items;
    private $Post;
    private $wherePhrase;
    private $orderPhrase;
    private $recordCount;

    function __construct($wherePhrase = null, $orderPhrase = '', $recordCount = 0) {
        $this->Items = array();
        $this->wherePhrase = $wherePhrase;
        $this->orderPhrase = $orderPhrase;
        $this->recordCount = $recordCount;

        $this->Post = ClassRegistry::init('Post');
        if (($this->Post instanceof Post) === false) {
            return;
        }

        $SQLPara = array();

        if ($this->wherePhrase !== null) {
            $SQLPara['conditions'] = $this->wherePhrase;
        }

        if ($this->orderPhrase !== '') {
            $SQLPara['order'] = $this->orderPhrase;
        }

        if ($this->recordCount !== 0) {
            $SQLPara['limit'] = $this->recordCount;
        }

		try {
	        $result = $this->Post->find('all', $SQLPara);
        } catch (PDOException $e) {
            Debugger::log($e->getMessage() . "\n" . $e->queryString, LOG_DEBUG);
            return;
        } catch (Exception $e) {
            Debugger::log($e->getMessage(), LOG_DEBUG);
            return;
        }

        foreach ($result as $key=>$val) {
            $this->Items[] = new OrgPost($val);
        }
    }
}

?>
