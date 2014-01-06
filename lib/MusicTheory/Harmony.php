<?php
/* Copyright (c) 2013 Eric Brisson

 Permission is hereby granted, free of charge, to any person obtaining a copy
 of this software and associated documentation files (the "Software"), to deal
 in the Software without restriction, including without limitation the rights
 to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 copies of the Software, and to permit persons to whom the Software is
 furnished to do so, subject to the following conditions:

 The above copyright notice and this permission notice shall be included in
 all copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 THE SOFTWARE. */

/**
 * This file defines classes related to harmony.
 *
 * @package MusicTheory
 */

/**
 * This class represents a music tonality or key.
 */
class Tonality {

    /** @var Note The tonic of the key. */
    private $tonic;

    /** @var boolean If true, the key is major. Otherwise, the key is minor. */
    private $major;

    /**
     * Constructor.
     *
     * @param Note $tonic The tonic of the key.
     * @param boolean $isMajor If true, the key is major. Otherwise,
     * the key is minor.
     * @return void
     */
    public function __construct($tonic, $isMajor) {
        $this->tonic = $tonic;
        $this->major = $isMajor;
    }

    /**
     * Returns the tonic of the key.
     *
     * @return Note
     */
    public function getTonic() {
        return $this->tonic;
    }

    /**
     * Specifies whether the arguments passed at instantiation time
     * produce a valid key (i.e. G major - an invalid key could be
     * G# major).
     *
     * @return boolean
     */
    public function isValidKey() {

        $mode = ($this->isMajor()) ? 'M' : 'm';
        $tonicLetter = $this->tonic->getLetter();
        $tonicAcc = $this->tonic->getAccidental();

        if (
                (
                ($mode == 'M') &&
                (
                (($tonicLetter == 'C') && ($tonicAcc == '')) ||
                (($tonicLetter == 'G') && ($tonicAcc == '')) ||
                (($tonicLetter == 'D') && ($tonicAcc == '')) ||
                (($tonicLetter == 'A') && ($tonicAcc == '')) ||
                (($tonicLetter == 'E') && ($tonicAcc == '')) ||
                (($tonicLetter == 'B') && ($tonicAcc == '')) ||
                (($tonicLetter == 'F') && ($tonicAcc == '#')) ||
                (($tonicLetter == 'C') && ($tonicAcc == '#')) ||
                (($tonicLetter == 'F') && ($tonicAcc == '')) ||
                (($tonicLetter == 'B') && ($tonicAcc == 'b')) ||
                (($tonicLetter == 'E') && ($tonicAcc == 'b')) ||
                (($tonicLetter == 'A') && ($tonicAcc == 'b')) ||
                (($tonicLetter == 'D') && ($tonicAcc == 'b')) ||
                (($tonicLetter == 'G') && ($tonicAcc == 'b')) ||
                (($tonicLetter == 'C') && ($tonicAcc == 'b'))
                ) ||
                (
                ($mode == 'm') &&
                (
                (($tonicLetter == 'A') && ($tonicAcc == '')) ||
                (($tonicLetter == 'E') && ($tonicAcc == '')) ||
                (($tonicLetter == 'B') && ($tonicAcc == '')) ||
                (($tonicLetter == 'F') && ($tonicAcc == '#')) ||
                (($tonicLetter == 'C') && ($tonicAcc == '#')) ||
                (($tonicLetter == 'G') && ($tonicAcc == '#')) ||
                (($tonicLetter == 'D') && ($tonicAcc == '#')) ||
                (($tonicLetter == 'A') && ($tonicAcc == '#')) ||
                (($tonicLetter == 'D') && ($tonicAcc == '')) ||
                (($tonicLetter == 'G') && ($tonicAcc == '')) ||
                (($tonicLetter == 'C') && ($tonicAcc == '')) ||
                (($tonicLetter == 'F') && ($tonicAcc == '')) ||
                (($tonicLetter == 'B') && ($tonicAcc == 'b')) ||
                (($tonicLetter == 'E') && ($tonicAcc == 'b')) ||
                (($tonicLetter == 'A') && ($tonicAcc == 'b'))
                )))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Indicates whether this key is major.
     *
     * @return boolean
     */
    public function isMajor() {
        return $this->major;
    }

    /**
     * Given a second key, indicate whether this key is equal to the
     * second key.
     *
     * The comparison involves both the tonic and the mode.
     *
     * @param Tonality $tonality The second key to be compared to this
     * key.
     * @return boolean
     */
    public function equals($tonality) {
        if ($tonality->getTonic()->equals($this->tonic) && $tonality->isMajor() == $this->major) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns a string representation of the key.
     *
     * The representation includes the tonic's letter name and accidental,
     * and the mode (e.g. 'Gn major', 'F# minor').
     *
     * @return string
     */
    public function __toString() {
        $mode = ($this->isMajor()) ? 'major' : 'minor';
        return ((string) $this->getTonic()->getLetterAccidental()) . ' ' . $mode;
    }

    /**
     * Given a clef, returns the key signature for this key.
     *
     * @param string $clef The given clef ('treble', 'bass', 'alto' or
     * 'tenor').
     * @return KeySignature
     */
    public function getKeySignature($clef) {
        return new KeySignature($this->getTonic(), $this->isMajor(), $clef);
    }

    /**
     * Given a mode, returns all existing keys in this mode.
     *
     * @param string $mode The given mode ('M' [major], 'm' [minor]).
     * @return Tonality[]
     */
    public static function getValidKeys($mode) {
        $arr = array();

        if ($mode == 'M') {
            array_push($arr, new Tonality(new Note('C', 'n', 4), true));
            array_push($arr, new Tonality(new Note('G', 'n', 4), true));
            array_push($arr, new Tonality(new Note('D', 'n', 4), true));
            array_push($arr, new Tonality(new Note('A', 'n', 4), true));
            array_push($arr, new Tonality(new Note('E', 'n', 4), true));
            array_push($arr, new Tonality(new Note('B', 'n', 4), true));
            array_push($arr, new Tonality(new Note('F', '#', 4), true));
            array_push($arr, new Tonality(new Note('C', '#', 4), true));
            array_push($arr, new Tonality(new Note('F', 'n', 4), true));
            array_push($arr, new Tonality(new Note('B', 'b', 4), true));
            array_push($arr, new Tonality(new Note('E', 'b', 4), true));
            array_push($arr, new Tonality(new Note('A', 'b', 4), true));
            array_push($arr, new Tonality(new Note('D', 'b', 4), true));
            array_push($arr, new Tonality(new Note('G', 'b', 4), true));
            array_push($arr, new Tonality(new Note('C', 'b', 4), true));
        } else if ($mode == 'm') {

            array_push($arr, new Tonality(new Note('A', 'n', 4), false));
            array_push($arr, new Tonality(new Note('E', 'n', 4), false));
            array_push($arr, new Tonality(new Note('B', 'n', 4), false));
            array_push($arr, new Tonality(new Note('F', '#', 4), false));
            array_push($arr, new Tonality(new Note('C', '#', 4), false));
            array_push($arr, new Tonality(new Note('G', '#', 4), false));
            array_push($arr, new Tonality(new Note('D', '#', 4), false));
            array_push($arr, new Tonality(new Note('A', '#', 4), false));
            array_push($arr, new Tonality(new Note('D', 'n', 4), false));
            array_push($arr, new Tonality(new Note('G', 'n', 4), false));
            array_push($arr, new Tonality(new Note('C', 'n', 4), false));
            array_push($arr, new Tonality(new Note('F', 'n', 4), false));
            array_push($arr, new Tonality(new Note('B', 'b', 4), false));
            array_push($arr, new Tonality(new Note('E', 'b', 4), false));
            array_push($arr, new Tonality(new Note('A', 'b', 4), false));
        }

        return $arr;
    }

}

/**
 * This class represents a key signature.
 */
class KeySignature {

    /** @var Note[] The ordered set of possible accidentals in treble clef. */
    private $KSTreble;

    /** @var Note[] The ordered set of possible accidentals in bass clef. */
    private $KSBass;

    /** @var Note[] The ordered set of possible accidentals in alto clef. */
    private $KSAlto;

    /** @var Note[] The ordered set of possible accidentals in tenor clef. */
    private $KSTenor;

    /** @var Note The tonic of the key signature. */
    private $tonic;

    /** @var boolean If true, the key signature is major. Otherwise, the key
      signature is minor. */
    private $isMaj;

    /** @var string The key signature's clef ('treble', 'bass', 'alto'
      or 'tenor'). */
    private $clef;

    /**
     * Constructor.
     *
     * @param Note $tonic The tonic of the key.
     * @param boolean $isMajor If true, the key signature is major. Otherwise,
     * the key signature is minor.
     * @param string $clef The key signature's clef ('treble', 'bass', 'alto'
     * or 'tenor').
     * @return void
     */
    public function __construct($tonic, $isMajor, $clef) {
        $this->tonic = $tonic;
        $this->isMaj = $isMajor;
        $this->clef = $clef;

        $this->KSTreble = array();
        $this->KSBass = array();
        $this->KSAlto = array();
        $this->KSTenor = array();



        if (!$isMajor) {
            $tonic = $tonic->getNoteFromInterval(new Interval('+', 'm', 3));
        }

        switch ($tonic->getLetterAccidental()) {
            case 'Cb':
                array_unshift($this->KSTreble, new Note('F', 'b', 4));
                array_unshift($this->KSBass, new Note('F', 'b', 2));
                array_unshift($this->KSAlto, new Note('F', 'b', 3));
                array_unshift($this->KSTenor, new Note('F', 'b', 3));
            case 'Gb':
                array_unshift($this->KSTreble, new Note('C', 'b', 5));
                array_unshift($this->KSBass, new Note('C', 'b', 3));
                array_unshift($this->KSAlto, new Note('C', 'b', 4));
                array_unshift($this->KSTenor, new Note('C', 'b', 4));
            case 'Db':
                array_unshift($this->KSTreble, new Note('G', 'b', 4));
                array_unshift($this->KSBass, new Note('G', 'b', 2));
                array_unshift($this->KSAlto, new Note('G', 'b', 3));
                array_unshift($this->KSTenor, new Note('G', 'b', 3));
            case 'Ab':
                array_unshift($this->KSTreble, new Note('D', 'b', 5));
                array_unshift($this->KSBass, new Note('D', 'b', 3));
                array_unshift($this->KSAlto, new Note('D', 'b', 4));
                array_unshift($this->KSTenor, new Note('D', 'b', 4));
            case 'Eb':
                array_unshift($this->KSTreble, new Note('A', 'b', 4));
                array_unshift($this->KSBass, new Note('A', 'b', 2));
                array_unshift($this->KSAlto, new Note('A', 'b', 3));
                array_unshift($this->KSTenor, new Note('A', 'b', 3));
            case 'Bb':
                array_unshift($this->KSTreble, new Note('E', 'b', 5));
                array_unshift($this->KSBass, new Note('E', 'b', 3));
                array_unshift($this->KSAlto, new Note('E', 'b', 4));
                array_unshift($this->KSTenor, new Note('E', 'b', 4));
            case 'Fn':
                array_unshift($this->KSTreble, new Note('B', 'b', 4));
                array_unshift($this->KSBass, new Note('B', 'b', 2));
                array_unshift($this->KSAlto, new Note('B', 'b', 3));
                array_unshift($this->KSTenor, new Note('B', 'b', 3));
                break;
        }

        $tonicLetter = $tonic->getLetterAccidental();
        switch ($tonicLetter) {
            case 'C#':
                array_unshift($this->KSTreble, new Note('B', '#', 4));
                array_unshift($this->KSBass, new Note('B', '#', 2));
                array_unshift($this->KSAlto, new Note('B', '#', 3));
                array_unshift($this->KSTenor, new Note('B', '#', 3));
            case 'F#':
                array_unshift($this->KSTreble, new Note('E', '#', 5));
                array_unshift($this->KSBass, new Note('E', '#', 3));
                array_unshift($this->KSAlto, new Note('E', '#', 4));
                array_unshift($this->KSTenor, new Note('E', '#', 4));
            case 'Bn':
                array_unshift($this->KSTreble, new Note('A', '#', 4));
                array_unshift($this->KSBass, new Note('A', '#', 2));
                array_unshift($this->KSAlto, new Note('A', '#', 3));
                array_unshift($this->KSTenor, new Note('A', '#', 3));
            case 'En':
                array_unshift($this->KSTreble, new Note('D', '#', 5));
                array_unshift($this->KSBass, new Note('D', '#', 3));
                array_unshift($this->KSAlto, new Note('D', '#', 4));
                array_unshift($this->KSTenor, new Note('D', '#', 4));
            case 'An':
                array_unshift($this->KSTreble, new Note('G', '#', 5));
                array_unshift($this->KSBass, new Note('G', '#', 3));
                array_unshift($this->KSAlto, new Note('G', '#', 4));
                array_unshift($this->KSTenor, new Note('G', '#', 3));
            case 'Dn':
                array_unshift($this->KSTreble, new Note('C', '#', 5));
                array_unshift($this->KSBass, new Note('C', '#', 3));
                array_unshift($this->KSAlto, new Note('C', '#', 4));
                array_unshift($this->KSTenor, new Note('C', '#', 4));
            case 'Gn':
                array_unshift($this->KSTreble, new Note('F', '#', 5));
                array_unshift($this->KSBass, new Note('F', '#', 3));
                array_unshift($this->KSAlto, new Note('F', '#', 4));
                array_unshift($this->KSTenor, new Note('F', '#', 3));
                break;
        }
    }

    /**
     * Returns the ordered set of accidentals in the key signature.
     *
     * @return Note[] Each note represents the accidental (e.g. 'F#5').
     */
    public function getAccidentals() {

        switch ($this->clef) {
            case 'treble';
                return $this->KSTreble;
            case 'bass':
                return $this->KSBass;
            case 'alto':
                return $this->KSAlto;
            case 'tenor':
                return $this->KSTenor;
            default:
                return $this->KSTreble;
        }
    }

    /**
     * Indicates whether a given note is in this key signature.
     *
     * @param Note $note The given note.
     * @param boolean $considerLetterOnly Optional. If true, only the
     * note's letter will be considered (e.g. Fb would be considered
     * present in the key signature for G major ('F#5'). If false, both
     * the note's letter and accidental will be considered (e.g. F# will
     * be part of the key signature for G major, but Fb will not). The
     * default is true.
     * @return boolean
     */
    public function isInKeySignature($note, $considerLetterOnly = true) {
        $i = null;
        for ($i = 0; $i < $this->KSTreble . length; $i++) {
            if ($considerLetterOnly && $this->KSTreble[i]->getLetter() == $note->getLetter()) {
                return true;
            } else if (!$considerLetterOnly && $this->KSTreble[i]->getLetter() == $note->getLetter() &&
                    Note($this->KSTreble[i])->getAccidental() == $note->getAccidental()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Indicates whether this key signature is composed of sharps.
     *
     * @return boolean
     */
    public function hasSharps() {
        if (strlen($this->KSTreble) > 0) {
            if ($this->KSTreble[0]->getAccidental() == '#') {
                return true;
            }
        }
        return false;
    }

    /**
     * Returns the key signature's tonic.
     *
     * @return Note
     */
    public function getTonic() {
        return $this->tonic;
    }

    /**
     * Indicates whether this key signature is major.
     *
     * @return boolean
     */
    public function isMajor() {
        return $this->isMaj;
    }

    /**
     * Returns a string representation of this key signature.
     *
     * This representation is a comma-separated list of accidentals
     * in the key signature (e.g. for A major in treble clef:
     * 'F#5,C#5,G#5').
     *
     * @return string
     */
    public function __toString() {
        return implode(',', $this->getAccidentals());
    }

}