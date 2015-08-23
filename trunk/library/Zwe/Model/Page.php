<?php

/**
 * @file library/Zwe/Model/Page.php
 * Classe che modellizza le pagine del sito.
 *
 * @category    Zwe
 * @package     Zwe_Model
 * @version     $Id: Page.php 146 2011-08-24 09:53:37Z flicofloc@gmail.com $
 */

/**
 * Classe che modellizza le pagine del sito.
 * Ogni pagina avrà una classe grazie a cui si potranno reperire tutte le info necessarie.
 *
 * @throws      Exception
 * @uses        Zwe_Model
 * @category    Zwe
 * @package     Zwe_Model
 */
class Zwe_Model_Page extends Zwe_Model
{
    protected $_name = 'page';
    protected $_primary = 'IDPage';

    /**
     * Il tipo della pagina.
     *
     * @see getPageType()
     * @var Zwe_Model_PageType
     */
    protected $_pageType = null;

    /**
     * L'indirizzo uri della pagina
     *
     * @var string
     */
    protected $_uri = null;

    /**
     * I parametri della pagina
     *
     * @var array
     */
    protected $_parameters = array();

    /**
     * La pagina attuale.
     * Memorizza l'oggetto della pagina attuale, in modo che sia sempre facilmente reperibile.
     *
     * @var Zwe_Model_Page
     */
    protected static $_thisPage = null;

    /**
     * L'elenco delle pagine fisse, che quindi non sono presenti sul database.
     *
     * @var array
     */
    public static $FixedPages = array('messages', 'login');

    public static $NoPages = array('admin', 'error');

    /**
     * Ritorna l'oggetto che identifica la pagina che si sta navigando ora.
     * Se l'oggetto non è ancora stato creato lo inizializza.
     *
     * @static
     * @param string $Url
     * @return Zwe_Model_Page
     */
    public static function getThisPage($Url = null)
    {
        if(isset($Url) && !isset(self::$_thisPage))
            self::$_thisPage = self::getPageByURL($Url);

        return self::$_thisPage;
    }

    /**
     * Trova una pagina grazie al suo url.
     * Ritorna un'istanza di Zwe_Model_Page che soddisfi l'url passato come parametro.
     *
     * @static
     * @throws Exception Se la pagina non è stata trovata
     * @param string $Url L'url della pagina da cercare
     * @return Zwe_Model_Page La pagina trovata
     */
    public static function getPageByURL($Url)
    {
        $Url = trim($Url, '/');
        $UrlArray = explode('/', $Url);
        $IDParent = 0;
        $OldPage = null;
        $Page = null;

        if(in_array($UrlArray[0], self::$FixedPages))
            $OldPage = self::getFixedPage($UrlArray[0]);
        elseif(in_array($UrlArray[0], self::$NoPages))
            $OldPage = new self();
        elseif('' == $Url)
            $OldPage = self::getDefaultPage();
        else
            foreach($UrlArray as $U)
            {
                $Page = self::getPageByName($U, $IDParent);
                $IDParent = $Page->IDPage;

                $OldPage = $Page;

                $Url = substr($Url, strlen($U));
                if(substr($Url, 0, 1) == '/')
                    $Url = substr($Url, 1);
                $OldPage->Parameters = $Url;
            }

        if($OldPage)
            return $OldPage;
        else
            throw new Exception("Page not found with URL: " . implode('/', $UrlArray));
    }

    public static function getFixedPage($Url)
    {
        $Class = 'Zwe_Model_Page_' . ucfirst($Url);
        return new $Class();
    }

    /**
     * Trova la pagina di default.
     * Ricerca nei parametri il nome della pagina di default, e se non lo trova lo crea.
     *
     * @static
     * @throws Exception Se la pagina non è stata trovata
     * @return Zwe_Model_Page La pagina di default
     */
    public static function getDefaultPage()
    {
        $DefaultPageName = Zend_Registry::get('parameters')->navigation->defaultPage;
        $Page = self::getPageByUrl($DefaultPageName);

        if($Page)
            return $Page;
        else
            throw new Exception("Page not found with URL: $DefaultPageName");
    }

    /**
     * @static
     * @param string $Type
     * @param bool $Tree
     * @return array
     * #todo Quando ci sarà PHP 5.3 bisogna sostituire il macheggio con get_class con new static()
     */
    protected static function getPagesByType($Type, $Tree = false)
    {
        $Class = get_class() . '_' . $Type;

        $ThePage = new $Class();
        $Select = $ThePage->select()->joinUsing('page_type', 'IDType', array())->where("Type = '$Type'");
        $Pages = $ThePage->fetchAll($Select);
        $Ret = array();

        if($Pages)
        {
            if($Tree)
                return $Pages->toArray();

            foreach($Pages as $Page)
            {
                $ThePage = new $Class();
                $ThePage->copyFromDb($Page);
                $Ret[] = $ThePage;
            }
        }

        return $Ret;
    }

    /**
     * Trova una pagina grazie al suo url e all'identificativo del padre.
     *
     * @static
     * @param string $Url
     * @param int $IDParent
     * @return Zwe_Model_Page
     */
    public static function getPageByName($Url, $IDParent = 0)
    {
        $Page = new self();
        $Page->fetchRowAndSet("Url = '$Url' AND IDParent = '$IDParent'");
        return self::getRightClass($Page);
    }

    /**
     * Istanzia per una specifica pagina l'oggetto proprio di quella pagina.
     * A seconda dell tipo di pagina, ne istanzia un oggetto specifico.
     *
     * @static
     * @param Zwe_Model_Page $Page La pagina da istanziare
     * @return Zwe_Model_Page
     */
    public static function getRightClass(Zwe_Model_Page $Page)
    {
        $Class = 'Zwe_Model_Page_' . $Page->Type->getController();
        $NewPage = new $Class();
        $NewPage->copy($Page);

        return $NewPage;
    }

    /**
     * Ritorna un array di pagine che compongono il menu al livello di $IDParent.
     * Le pagine ritornate sono ordinate per posizione.
     *
     * @static
     * @throws Exception
     * @param int $IDParent L'identificativo della pagina di cui si vuole il menu
     * @return array Le pagine che compongono il menu ricercato
     */
    public static function getMenu($IDParent = 0)
    {
        $Page = new self();
        $Menu = $Page->fetchAll("IDParent = '$IDParent'", 'Position');

        if(!$Menu)
            throw new Exception("Non è stato trovato alcun menu");

        return $Menu->toArray();
    }

    public static function getTree($IDParent = 0)
    {
        try
        {
            $Pages = self::getMenu($IDParent);
            foreach($Pages as &$Page)
            {
                $Page['Child'] = self::getTree($Page['IDPage']);
            }

            return $Pages;
        }
        catch(Exception $E)
        {
            return array();
        }
    }

    public static function addPage($Title, $IDParent, $Url, $IDType, $Text)
    {
        $Page = new self();
        $Position = $Page->getAdapter()->fetchRow($Page->getAdapter()->select()->from('page', array('Position' => new Zend_Db_Expr('IFNULL(MAX(Position), 0) + 1')))->where("IDParent = '$IDParent'"));
        $Position = $Position['Position'];

        $Data = array('Title' => $Title, 'IDParent' => $IDParent, 'Url' => $Url, 'IDType' => $IDType, 'Text' => $Text, 'Position' => $Position);

        return $Page->insert($Data);
    }

    public static function editPage($IDPage, $Title, $IDParent, $Url, $IDType, $Text)
    {
        $Page = new self();
        $Data = array('Title' => $Title, 'IDParent' => $IDParent, 'Url' => $Url, 'IDType' => $IDType, 'Text' => $Text);

        return $Page->update($Data, "IDPage = '$IDPage'");
    }

    public static function deletePage($IDPage)
    {
        $Page = new self();
        $Rows = 0;
        $Children = $Page->fetchAll("IDParent = '$IDPage'");

        if($Children)
        {
            foreach($Children as $Child)
            {
                $Rows += self::deletePage($Child->IDPage);
            }
        }

        return $Page->delete("IDPage = '$IDPage'") + $Rows;
    }

    public static function orderPages(array $Order, $IDParent = 0)
    {
        $Position = 1;
        $ThePage = new self();

        foreach($Order as $IDPage => $Child)
        {
            $Data = array('Position' => $Position++, 'IDParent' => $IDParent);
            $ThePage->update($Data, "IDPage = '$IDPage'");

            if(is_array($Child))
                self::orderPages($Child, $IDPage);
        }
    }

    public static function getPageByID($IDPage)
    {
        $Page = new self();
        $Page->fetchRowAndSet("IDPage = '$IDPage'");

        return self::getRightClass($Page);
    }

    /**
     * Inizializza il contenuto delle specifiche pagine.
     * Viene sovrascritto in ogni classe figlia per inizializzarne le specifiche proprietà.
     */
    protected function specificPageInit()
    {

    }

    /**
     * Getter del tipo della pagina.
     * Ritorna l'oggetto contenente il tipo della pagina.
     *
     * @return Zwe_Model_PageType
     */
    public function getPageType()
    {
        if(null === $this->_pageType)
            $this->_pageType = Zwe_Model_PageType::getType($this->IDType);

        return $this->_pageType;
    }

    /**
     * Getter dell'attributo $_uri.
     *
     * @return string L'uri della pagina
     */
    public function getUri()
    {
        if(!isset($this->_uri))
        {
            $Uri = '';
            $IDParent = $this->IDParent;

            while($IDParent > 0)
            {
                $Page = $this->fetchRow("IDParent = '$IDParent'");
                $IDParent = $Page->IDParent;
                $Uri = '/' . $Page->Url . $Uri;
            }

            if('' == $Uri)
                $Uri = '/';

            $this->_uri = $Uri;
        }

        return $this->_uri;
    }

    /**
     * Elimina il primo elemento dell'oggetto $_parameters.
     *
     * @return array I nuovi parametri
     */
    public function shiftParameters()
    {
        array_shift($this->_parameters);

        return $this->_parameters;
    }

    public function copy(Zwe_Model_Page $Page)
    {
        parent::copy($Page);
        $this->_pageType = $Page->getPageType();
        $this->specificPageInit();

        return $this;
    }

    public function copyFromDb(Zend_Db_Table_Row $Object)
    {
        parent::copyFromDb($Object);
        $this->getPageType();
        $this->specificPageInit();

        return $this;
    }

    public function toForm()
    {
        return array('title' => $this->Title,
                     'parent' => $this->IDParent,
                     'url' => $this->Url,
                     'type' => $this->IDType,
                     'text' => $this->Text,
                     'id' => $this->IDPage);
    }

    public function __get($Name)
    {
        if('Type' == $Name)
            return $this->getPageType();
        elseif('Parameters' == $Name)
            return $this->_parameters;
        else
            return parent::__get($Name);
    }

    public function __set($Name, $Value)
    {
        if('Type' == $Name)
        {
            if($Value instanceof Zwe_Model_PageType)
                $this->_pageType = $Value;
            else
                throw new Exception('$Value must be an instance of Zwe_Model_PageType');
        }
        elseif('Parameters' == $Name)
        {
            if(is_array($Value))
                $this->_parameters = $Value;
            elseif(is_string($Value))
                $this->_parameters = explode('/', $Value);
            else
                $this->_parameters = null;
        }
        else
            parent::__set($Name, $Value);
    }
}

?>