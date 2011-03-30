<?php
/**
 * Description of End
 *
 * @author aheadley
 */
class NBT_Tag_End extends NBT_FiniteTag {
  static protected $_tagType = NBT_Tag::TYPE_END;
  
  static public function getStructFormat() {
    return 'c';
  }

  static public function getByteCount() {
    return 1;
  }

  public function __construct() {
    $this->_type = new NBT_Tag_Byte( $this->getType() );
    $this->_data = "\0";
  }

  public function set( $value ) {
    throw new NBT_Tag_Exception( "End tags cannot have a value" );
  }

  public function write( $handle ) {
    //skip the call to parent::write()
    if( !fwrite( $handle, pack( self::getStructFormat(), $this->_data ) ) ) {
      throw new NBT_Tag_Exception( "Failed to write tag data: {$this->_data}" );
    }
  }
}
