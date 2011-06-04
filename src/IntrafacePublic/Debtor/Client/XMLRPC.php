<?php
/**
 * Communicates with the Intraface Debtor-system
 *
 * PHP version 5
 *
 * @category  IntrafacePublic
 * @package   IntrafacePublic_Debtor_XMLRPC
 * @author    Lars Olesen <lars@legestue.net>
 * @author    Sune Jensen <sj@sunet.dk>
 * @copyright 2007 The Authors
 * @license   http://creativecommons.org/licenses/by-sa/2.5/legalcode Creative Commons / Share A Like license
 * @version   @package-version@
 * @link      http://public.intraface.dk/index.php?package=IntrafacePublic_Debtor_XMLRPC
 */

/**
 * Required from the PEAR library - used for error handling
 */
require_once 'PEAR.php';

/**
 * Required from the PEAR library - used for the actual communication
 */
require_once 'XML/RPC2/Client.php';

/**
 * Communicates with the Intraface Debtor-system
 *
 * @category  IntrafacePublic
 * @package   IntrafacePublic_Debtor_XMLRPC
 * @author    Lars Olesen <lars@legestue.net>
 * @author    Sune Jensen <sj@sunet.dk>
 * @copyright 2007 The Authors
 * @license   http://creativecommons.org/licenses/by-sa/2.5/legalcode Creative Commons / Share A Like license
 * @version   @package-version@
 * @link      http://public.intraface.dk/index.php?package=IntrafacePublic_Debtor_XMLRPC
 */
class IntrafacePublic_Debtor_Client_XMLRPC
{
    /**
     * @var object XML_RPC2_Client object
     */
    protected $client;

    /**
     * @var struct options
     */
    protected $options = array(
        'prefix' => 'debtor.',
        'encoding' => 'utf-8'
    );

    /**
     * @var struct members (private_key, session_id)
     */
    protected $credentials;

    /**
     * Constructor
     *
     * @param struct  $credentials Credentials provided by intraface
     * @param boolean $debug       Debug when set to true
     * @param string  $url         The server url
     *
     * @return void
     */
    public function __construct($credentials, $debug = false, $url = '')
    {
        if ($url == '') {
            $url = 'http://www.intraface.dk/xmlrpc/debtor/server.php';
        }
        $this->options['debug'] = $debug;
        $this->client           = XML_RPC2_Client::create($url, $this->options);
        $this->credentials      = $credentials;
    }

    /**
     * get a debtor
     *
     * @param integer $id Debtor id
     *
     * @return array
     */
    public function getDebtor($id)
    {
        try {
            return $this->client->getDebtor($this->credentials, intval($id));
        } catch (XML_RPC2_FaultException $e) {
            throw new Exception('Exception #' . $e->getFaultCode() . ' : ' . $e->getFaultString());
        } catch (Exception $e) {
            throw new Exception('Exception: ' . $e->getMessage());
        }
    }

    /**
     * getDebtorList
     *
     * @param string  $type       Can be quotation, order or invoice
     * @param integer $contact_id The contact id
     *
     * @return array
     */
    public function getDebtorList($type, $contact_id)
    {
        try {
            return $this->client->getDebtorList($this->credentials, $type, intval($contact_id));
        } catch (XML_RPC2_FaultException $e) {
            throw new Exception('Exception #' . $e->getFaultCode() . ' : ' . $e->getFaultString());
        } catch (Exception $e) {
            throw new Exception('Exception: ' . $e->getMessage());
        }
    }

    /**
     * Get a debtor pdf
     *
     * @param integer $id The id of the debtorpdf
     *
     * @deprecated
     *
     * @return array
     */
    public function getDebtorPdf($id)
    {
        try {
            $string = $this->client->getDebtorPdf($this->credentials, intval($id));
            return $string;
        } catch (XML_RPC2_FaultException $e) {
            throw new Exception('Exception #' . $e->getFaultCode() . ' : ' . $e->getFaultString());
        } catch (Exception $e) {
            throw new Exception('Exception: ' . $e->getMessage());
        }
    }
}
