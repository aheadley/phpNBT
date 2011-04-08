<?php
/**
 * Description of File
 *
 * @author aheadley
 */
class NBT_File extends NBT_Data {
  private $_filename  = null;

  public function __construct( $filename ) {
    $this->_filename = $filename;
    $handle = fopen( "compress.zlib://{$this->_filename}", 'rb' );
    parent::__construct( $handle );
    fclose( $handle );
  }

  public function __toString() {
    return "NBT_File({$this->_filename})";
  }

  public function write( $filename = null ) {
    if( is_null( $filename ) ) {
      $filename = $this->_filename;
    }
    $handle = fopen( "compress.zlib://${filename}", 'wb' );
    parent::write( $handle );
    fclose( $handle );
  }
}