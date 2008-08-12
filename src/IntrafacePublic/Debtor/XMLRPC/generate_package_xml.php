<?php
/**
 * package.xml generation script
 *
 * @package IntrafacePublic_Contact_XMLRPC
 * @author  Lars Olesen <lars@legestue.net>
 * @since   0.1.0
 * @version @package-version@
 */

require_once 'PEAR/PackageFileManager2.php';

$version = '0.1.0';
$stability = 'alpha';
$notes = '* initial release as PEAR package';

PEAR::setErrorHandling(PEAR_ERROR_DIE);
$pfm = new PEAR_PackageFileManager2();
$pfm->setOptions(
    array(
        'baseinstalldir'    => 'IntrafacePublic/Debtor/XMLRPC',
        'filelistgenerator' => 'file',
        'packagedirectory'  => dirname(__FILE__),
        'packagefile'       => 'package.xml',
        'ignore'            => array(
            'generate_package_xml.php',
            'package.xml',
            '*.tgz'
            ),
        'dir_roles' => array(
        ),
        'exceptions'        => array(
        ),
        'simpleoutput'      => true,
    )
);

$pfm->setPackage('IntrafacePublic_Debtor_XMLRPC');
$pfm->setSummary('Tools for usage with Intraface');
$pfm->setDescription('Tools to use with the Intraface');
$pfm->setChannel('public.intraface.dk');
$pfm->setLicense('BSD license', 'http://www.opensource.org/licenses/bsd-license.php');
$pfm->addMaintainer('lead', 'lsolesen', 'Lars Olesen', 'lars@legestue.net');

$pfm->setPackageType('php');

$pfm->setAPIVersion($version);
$pfm->setReleaseVersion($version);
$pfm->setAPIStability($stability);
$pfm->setReleaseStability($stability);
$pfm->setNotes($notes);
$pfm->addRelease();

$pfm->addGlobalReplacement('package-info', '@package-version@', 'version');

$pfm->clearDeps();
$pfm->setPhpDep('4.3.0');
$pfm->setPearinstallerDep('1.5.0');
$pfm->addPackageDepWithChannel('required', 'XML_RPC2', 'pear.php.net', '1.0.0');

$pfm->generateContents();

if (isset($_GET['make']) || (isset($_SERVER['argv']) && @$_SERVER['argv'][1] == 'make')) {
    if ($pfm->writePackageFile()) {
        exit('file written');
    }
} else {
    $pfm->debugPackageFile();
}
?>