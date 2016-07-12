<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * xmcontent module
 *
 * @copyright       XOOPS Project (http://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author          Mage Gregory (AKA Mage)
 */

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

class xmcontent_content extends XoopsObject
{
// constructor
    function __construct()
    {
        $this->initVar('content_id',XOBJ_DTYPE_INT,null,false,11);
        $this->initVar('content_title',XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('content_text',XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('content_status', XOBJ_DTYPE_INT, 1, false, 1);
        $this->initVar('content_mkeyword', XOBJ_DTYPE_TXTAREA, '', false);
        $this->initVar('content_mdescription', XOBJ_DTYPE_TXTAREA, '', false);
        $this->initVar('content_maindisplay', XOBJ_DTYPE_INT, 1, false, 1);
        $this->initVar('content_weight', XOBJ_DTYPE_INT, 0, false, 5);
        $this->initVar('content_dopdf', XOBJ_DTYPE_INT, 1, false, 1);
        $this->initVar('content_doprint', XOBJ_DTYPE_INT, 1, false, 1);
        $this->initVar('content_dosocial', XOBJ_DTYPE_INT, 1, false, 1);
        $this->initVar('content_domail', XOBJ_DTYPE_INT, 1, false, 1);
        $this->initVar('content_dotitle', XOBJ_DTYPE_INT, 1, false, 1);
        $this->initVar('dohtml', XOBJ_DTYPE_INT, 1, false);
    }
    function get_new_enreg()
    {
        global $xoopsDB;
        $new_enreg = $xoopsDB->getInsertId();
        return $new_enreg;
    }
    function xmcontent_content()
    {
        $this->__construct();
    }
    function getForm($action = false)
    {
        if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        
        global $xoopsModuleConfig;
        
        //form title
        $title = $this->isNew() ? sprintf(_AM_XMCONTENT_ADD) : sprintf(_AM_XMCONTENT_EDIT);
        
        $form = new XoopsThemeForm($title, 'form', $action, 'post', true);
        
        if (!$this->isNew()) {
            $form->addElement(new XoopsFormHidden('content_id', $this->getVar('content_id')));
            $status = $this->getVar('content_status');
            $weight = $this->getVar('content_weight');
        } else {
            $status = 1;
            $weight = 0;
        }

        // title
        $form->addElement(new XoopsFormText(_AM_XMCONTENT_CONTENT_TITLE, 'content_title', 50, 255, $this->getVar('content_title')), true);
        
        // text
        $editor_configs=array();
        $editor_configs["name"] ='content_text';
        $editor_configs["value"] = $this->getVar('content_text', 'e');
        $editor_configs["rows"] = 20;
        $editor_configs["cols"] = 160;
        $editor_configs["width"] = "100%";
        $editor_configs["height"] = "400px";
        $editor_configs["editor"] = $xoopsModuleConfig['admin_editor'];
        $form->addElement( new XoopsFormEditor(_AM_XMCONTENT_CONTENT_TEXT, 'content_text', $editor_configs), true);
        
        // weight
        $form->addElement(new XoopsFormText(_AM_XMCONTENT_CONTENT_WEIGHT, 'content_weight', 5, 5, $weight), true);
        
        // status
        $form_status = new XoopsFormRadio(_AM_XMCONTENT_CONTENT_STATUS, 'content_status', $status);
        $options = array(1 => _AM_XMCONTENT_CONTENT_STATUS_A, 0 =>_AM_XMCONTENT_CONTENT_STATUS_NA,);
        $form_status->addOptionArray($options);
        $form->addElement($form_status);
        
        // keyword
        $form->addElement(new XoopsFormTextArea (_AM_XMCONTENT_CONTENT_KEYWORD, 'content_mkeyword', $this->getVar('content_mkeyword', 'e'), 2, 60), false);
        
        // description
        $form->addElement(new XoopsFormTextArea (_AM_XMCONTENT_CONTENT_DESCRIPTION, 'content_mdescription', $this->getVar('content_mdescription', 'e'), 2, 60), false);
        
        // maindisplay
        $form->addElement(new XoopsFormRadioYN(_AM_XMCONTENT_CONTENT_MAINDISPLAY, 'content_maindisplay', $this->getVar('content_maindisplay')));
        
        // dopdf
        $form->addElement(new XoopsFormRadioYN(_AM_XMCONTENT_CONTENT_DOPDF, 'content_dopdf', $this->getVar('content_dopdf')));
        
        // doprint
        $form->addElement(new XoopsFormRadioYN(_AM_XMCONTENT_CONTENT_DOPRINT, 'content_doprint', $this->getVar('content_doprint')));
        
        // dosocial
        $form->addElement(new XoopsFormRadioYN(_AM_XMCONTENT_CONTENT_DOSOCIAL, 'content_dosocial', $this->getVar('content_dosocial')));
        
        // domail
        $form->addElement(new XoopsFormRadioYN(_AM_XMCONTENT_CONTENT_DOMAIL, 'content_domail', $this->getVar('content_domail')));
        
        // dotitle
        $form->addElement(new XoopsFormRadioYN(_AM_XMCONTENT_CONTENT_DOTITLE, 'content_dotitle', $this->getVar('content_dotitle')));

        $form->addElement(new XoopsFormHidden('op', 'save'));
        // submitt
        $form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));

        return $form;
    }
}

class xmcontentxmcontent_contentHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db)
    {
        parent::__construct($db, "xmcontent_content", 'xmcontent_content', 'content_id', 'content_title');
    }
}