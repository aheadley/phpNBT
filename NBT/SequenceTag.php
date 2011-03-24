<?php
/**
 * Description of Sequence
 *
 * @author aheadley
 */
abstract class NBT_SequenceTag extends NBT_Tag
  implements ArrayAccess {

  public function offsetExists( $offset ) {
    return array_key_exists( $offset, $this->_data );
  }

  public function offsetGet( $offset ) {
    if( $this->offsetExists( $offset ) ) {
      return $this->_data[$offset];
    }
  }

  public function offsetSet( $offset, NBT_Tag $value ) {
    $this->_data[$offset] = $value;
  }

  public function offsetUnset( $offset ) {
    if( $this->offsetExists( $offset ) ) {
      unset( $this->_data[$offset] );
    }
  }
}
