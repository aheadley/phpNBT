<?php

class Region_File {
  private $_filename  = null;
  private $_chunks    = array();

  public function __construct( $filename ) {
    $this->_filename = $filename;
  }

  public function getChunk( $x, $y ) {
    return $this->_chunks[$x][$y];
  }

  public function getChunkMtime( $x, $y ) {
    
  }

  public function setChunk( $x, $y, NBT_Data $chunk ) {

  }

  public function setChunkMtime( $x, $y, $time ) {
    
  }

  public function write( $filename = null ) {
    
  }

  protected function _load() {
    
  }

  protected function _writeHeader( $handle ) {

  }

  protected function _writeChunk( NBT_Data $chunk ) {
    
  }
}