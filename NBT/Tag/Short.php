<?php
/**
 * Description of Short
 *
 * @author aheadley
 */

class NBT_Tag_Short extends NBT_FiniteTag {
  static protected $_tagType  = self::TYPE_SHORT;

  static public function getStructFormat() {
    return 'n';
  }

  static public function getByteCount() {
    return 2;
  }

  public function set( $value ) {
    $value = intval( $value );
    $this->_data = $value >= pow( 2, 15 ) ? $value - pow( 2, 16 ) : $value;
  }
}