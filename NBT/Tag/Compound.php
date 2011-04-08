<?php
/**
 * Description of Compound
 *
 * @author aheadley
 */
class NBT_Tag_Compound extends NBT_SequenceTag {
  
  static protected $_tagType  = self::TYPE_COMPOUND;

  static public function parse( $handle, $hasName = true ) {
    if( $hasName ) {
      $name = NBT_Tag_String::parse( $handle, false );
    } else {
      $name = null;
    }
    $tags = array();
    do {
      $newTagClass = NBT_Tag::getTypeClass(
        NBT_Tag_Byte::parse( $handle, false )->get() );
      if( $newTagClass === 'NBT_Tag_End' ) {
        break;
        $newTag = $newTagClass::parse( $handle, false );
      } else {
        $newTag = $newTagClass::parse( $handle, true );
        $tags[$newTag->getName()] = $newTag;
      }
    } while( $newTagClass !== 'NBT_Tag_End' );
    return new NBT_Tag_Compound( $tags, $name );
  }

  public function __construct( array $data, $name = null ) {
    parent::__construct( $data, $name );
  }

  public function __get( $name ) {
    return $this[$name];
  }

  public function __set( $name, $value ) {
    $this[$name] = $value;
  }

  public function set( $value ) {
    foreach( $value as $tag ) {
      if( !( $tag instanceof NBT_Tag ) ) {
        throw new NBT_Tag_Exception( 'NBT_Tag_Compound can only hold other NBT_Tag objects' );
      }
    }
    $this->_data = $value;
  }

  public function write( $handle ) {
    parent::write( $handle );
    foreach( $this->_data as $tag ) {
      $tag->write( $handle );
    }
  }
}
