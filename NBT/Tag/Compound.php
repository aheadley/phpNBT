<?php
/**
 * Description of Compound
 *
 * @author aheadley
 */
class NBT_Tag_Compound extends NBT_Tag_Sequence {
  static private $_tagType = NBT_Tag::TYPE_COMPOUND;

  public function __construct( array $data, $name = null ) {
    parent::__construct( $data, $name );
  }

  public function set( array $value ) {
    $this->_data = $value;
  }
}
