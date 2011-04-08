<?php
/**
 * Description of End
 *
 * @author aheadley
 */
class NBT_Tag_End extends NBT_Tag {
  protected $_typeId  = self::TYPE_END;
  
  static public function parse( $handle, $hasName = true ) {
    if( $hasName ) {
      list(, $data ) = unpack( 'c', fread( $handle, 1 ) );
      if( !assert( $data == "\0" ) ) {
        throw new NBT_Tag_Exception( "Invalid end tag data: ${data}" );
      }
    } else {
      $data = null;
    }
    return new NBT_Tag_End( $data );
  }

  public function __construct( $data = null ) {
    $this->_type = new NBT_Tag_Byte( $this->getTypeId() );
    if( !is_null( $data ) ) {
      $this->_data = "\0";
    } else {
      $this->_data = null;
    }
  }

  public function set( $value ) {
    throw new NBT_Tag_Exception( "End tags cannot have a value" );
  }

  public function write( $handle ) {
    parent::write( $handle );
    if( !is_null( $this->_data ) ) {
      if( !fwrite( $handle, pack( 'c', $this->_data ) ) ) {
        throw new NBT_Tag_Exception( "Failed to write tag data: {$this->_data}" );
      }
    }
  }
}
