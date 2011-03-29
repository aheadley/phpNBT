<?php
/**
 * Description of Tag
 *
 * @author aheadley
 */
abstract class NBT_Tag {

  const TYPE_END        = 0;
  const TYPE_BYTE       = 1;
  const TYPE_SHORT      = 2;
  const TYPE_INT        = 3;
  const TYPE_LONG       = 4;
  const TYPE_FLOAT      = 5;
  const TYPE_DOUBLE     = 6;
  const TYPE_BYTE_ARRAY = 7;
  const TYPE_STRING     = 8;
  const TYPE_LIST       = 9;
  const TYPE_COMPOUND   = 10;

  protected $_type  = null;
  protected $_name  = null;
  protected $_data  = null;

  static public function getTypeClass( $type ) {
    switch( $type ) {
      case self::TYPE_END:
        return 'NBT_Tag_End';
        break;
      case self::TYPE_BYTE:
        return 'NBT_Tag_Byte';
        break;
      case self::TYPE_SHORT:
        return 'NBT_Tag_Byte';
        break;
      case self::TYPE_INT:
        return 'NBT_Tag_Int';
        break;
      case self::TYPE_LONG:
        return 'NBT_Tag_Long';
        break;
      case self::TYPE_FLOAT:
        return 'NBT_Tag_Long';
        break;
      case self::TYPE_DOUBLE:
        return 'NBT_Tag_Long';
        break;
      case self::TYPE_BYTE_ARRAY;
        return 'NBT_Tag_ByteArray';
        break;
      case self::TYPE_STRING:
        return 'NBT_Tag_String';
        break;
      case self::TYPE_LIST:
        return 'NBT_Tag_List';
        break;
      case self::TYPE_COMPOUND:
        return 'NBT_Tag_Compound';
        break;
      default:
        throw new NBT_Tag_Exception( "Unknown tag type: {$type}" );
    }
  }

  public function __construct( $data, $name = null ) {
    $this->_type = new NBT_Tag_Byte( $this->getType() );
    $this->set( $data );
    if( !is_null( $name ) ) {
      $this->_name = new NBT_Tag_String( $name );
    }
  }

  public function __toString() {
    if( !is_null( $this->_name ) ) {
      return sprintf( '%s(%s:%s)', get_class( $this ), $this->_name->get(),
        $this->get() );
    } else {
      return sprintf( '%s(%s)', get_class( $this ), $this->get() );
    }
  }

  public function get() {
    return $this->_data;
  }

  public function getType() {
    return self::$_tagType;
  }

  public function write( $handle ) {
    $this->_type->write( $handle );
  }

  abstract public function set( $value );
  abstract static public function parse( $handle );
}