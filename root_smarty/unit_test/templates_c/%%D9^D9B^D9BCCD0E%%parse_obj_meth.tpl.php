<?php /* Smarty version 2.6.10, created on 2005-08-10 19:23:11
         compiled from parse_obj_meth.tpl */ ?>
<?php echo $this->_tpl_vars['obj']->meth($this->_tpl_vars['foo'],2.5); ?>

<?php echo $this->_tpl_vars['obj']->meth(2.5,$this->_tpl_vars['foo']); ?>

<?php echo $this->_tpl_vars['obj']->meth(2.5); ?>

<?php echo $this->_tpl_vars['obj']->meth($this->_tpl_vars['obj']->val,'foo'); ?>

<?php echo $this->_tpl_vars['obj']->meth('foo',$this->_tpl_vars['obj']->val); ?>

<?php echo $this->_tpl_vars['obj']->meth('foo',$this->_tpl_vars['foo']); ?>

<?php echo $this->_tpl_vars['obj']->meth($this->_tpl_vars['obj']->arr['one'],2); ?>

<?php echo $this->_tpl_vars['obj']->meth($this->_tpl_vars['obj']->meth('foo',$this->_tpl_vars['foo'])); ?>
