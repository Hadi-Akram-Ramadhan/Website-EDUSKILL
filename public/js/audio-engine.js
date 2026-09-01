/**
 * EduSkill Web Audio Engine
 * Pure procedural Web Audio API synthesis for zero-latency interactive SFX and dynamic BGM.
 * No external media file dependencies or network latency.
 */

class EduAudioEngine {
    constructor() {
        this.ctx = null;
        this.masterGain = null;
        this.sfxGain = null;
        this.bgmGain = null;

        // Sound Settings & Storage
        this.isSfxMuted = localStorage.getItem('eduskill_sfx_muted') === 'true';
        this.isBgmMuted = localStorage.getItem('eduskill_bgm_muted') === 'true';
        this.currentBgmMode = null; // 'quiz' | 'project'
        this.bgmInterval = null;
        this.bgmStep = 0;
        this.bgmIntensity = 0.2; // 0.0 to 1.0 based on quiz progress
        this.isInitialized = false;

        this._setupAutoUnlock();
    }

    /**
     * Unlock AudioContext on first user gesture (touch/click/keydown)
     */
    _setupAutoUnlock() {
        const unlock = () => {
            this.init();
            if (this.ctx && this.ctx.state === 'suspended') {
                this.ctx.resume();
            }
            window.removeEventListener('click', unlock);
            window.removeEventListener('touchstart', unlock);
            window.removeEventListener('keydown', unlock);
        };
        window.addEventListener('click', unlock, { passive: true });
        window.addEventListener('touchstart', unlock, { passive: true });
        window.addEventListener('keydown', unlock, { passive: true });
    }

    init() {
        if (this.isInitialized && this.ctx) {
            if (this.ctx.state === 'suspended') this.ctx.resume();
            return;
        }

        const AudioContextClass = window.AudioContext || window.webkitAudioContext;
        if (!AudioContextClass) return;

        this.ctx = new AudioContextClass();

        // Master Gain
        this.masterGain = this.ctx.createGain();
        this.masterGain.gain.setValueAtTime(1.0, this.ctx.currentTime);
        this.masterGain.connect(this.ctx.destination);

        // SFX Gain Node
        this.sfxGain = this.ctx.createGain();
        this.sfxGain.gain.setValueAtTime(this.isSfxMuted ? 0 : 0.7, this.ctx.currentTime);
        this.sfxGain.connect(this.masterGain);

        // BGM Gain Node
        this.bgmGain = this.ctx.createGain();
        this.bgmGain.gain.setValueAtTime(this.isBgmMuted ? 0 : 0.18, this.ctx.currentTime);
        this.bgmGain.connect(this.masterGain);

        this.isInitialized = true;
    }

    /* -------------------------------------------------------------
     * SOUND EFFECTS (SFX)
     * ----------------------------------------------------------- */

    /**
     * UI Tap / Button Click Feedback
     */
    playTap() {
        if (this.isSfxMuted) return;
        this.init();
        if (!this.ctx) return;

        const now = this.ctx.currentTime;
        const osc = this.ctx.createOscillator();
        const gain = this.ctx.createGain();

        osc.type = 'sine';
        osc.frequency.setValueAtTime(540, now);
        osc.frequency.exponentialRampToValueAtTime(880, now + 0.035);

        gain.gain.setValueAtTime(0.2, now);
        gain.gain.exponentialRampToValueAtTime(0.001, now + 0.035);

        osc.connect(gain);
        gain.connect(this.sfxGain);

        osc.start(now);
        osc.stop(now + 0.04);
    }

    /**
     * Card / Option Select Ping
     */
    playSelect() {
        if (this.isSfxMuted) return;
        this.init();
        if (!this.ctx) return;

        const now = this.ctx.currentTime;
        const osc = this.ctx.createOscillator();
        const gain = this.ctx.createGain();

        osc.type = 'triangle';
        osc.frequency.setValueAtTime(660, now);
        osc.frequency.exponentialRampToValueAtTime(990, now + 0.06);

        gain.gain.setValueAtTime(0.25, now);
        gain.gain.exponentialRampToValueAtTime(0.001, now + 0.08);

        osc.connect(gain);
        gain.connect(this.sfxGain);

        osc.start(now);
        osc.stop(now + 0.09);
    }

    /**
     * Correct Answer Chime (Sparkling major arpeggio: C5 - E5 - G5 - C6)
     */
    playCorrect() {
        if (this.isSfxMuted) return;
        this.init();
        if (!this.ctx) return;

        const now = this.ctx.currentTime;
        const notes = [
            { f: 523.25, t: 0.00, d: 0.25 }, // C5
            { f: 659.25, t: 0.07, d: 0.25 }, // E5
            { f: 783.99, t: 0.14, d: 0.25 }, // G5
            { f: 1046.50, t: 0.21, d: 0.50 } // C6
        ];

        notes.forEach(n => {
            const osc = this.ctx.createOscillator();
            const gain = this.ctx.createGain();

            osc.type = 'triangle';
            osc.frequency.setValueAtTime(n.f, now + n.t);

            gain.gain.setValueAtTime(0.32, now + n.t);
            gain.gain.exponentialRampToValueAtTime(0.001, now + n.t + n.d);

            osc.connect(gain);
            gain.connect(this.sfxGain);

            osc.start(now + n.t);
            osc.stop(now + n.t + n.d);
        });
    }

    /**
     * Wrong Answer Wobble
     */
    playWrong() {
        if (this.isSfxMuted) return;
        this.init();
        if (!this.ctx) return;

        const now = this.ctx.currentTime;
        const osc = this.ctx.createOscillator();
        const gain = this.ctx.createGain();

        osc.type = 'sawtooth';
        osc.frequency.setValueAtTime(175, now);
        osc.frequency.exponentialRampToValueAtTime(85, now + 0.32);

        // Lowpass filter for smooth soft punch
        const filter = this.ctx.createBiquadFilter();
        filter.type = 'lowpass';
        filter.frequency.setValueAtTime(480, now);

        gain.gain.setValueAtTime(0.3, now);
        gain.gain.exponentialRampToValueAtTime(0.001, now + 0.32);

        osc.connect(filter);
        filter.connect(gain);
        gain.connect(this.sfxGain);

        osc.start(now);
        osc.stop(now + 0.33);
    }

    /**
     * Heart Loss Warning Sound
     */
    playHeartLoss() {
        if (this.isSfxMuted) return;
        this.init();
        if (!this.ctx) return;

        const now = this.ctx.currentTime;
        const osc = this.ctx.createOscillator();
        const gain = this.ctx.createGain();

        osc.type = 'sine';
        osc.frequency.setValueAtTime(120, now);
        osc.frequency.exponentialRampToValueAtTime(45, now + 0.28);

        gain.gain.setValueAtTime(0.4, now);
        gain.gain.exponentialRampToValueAtTime(0.001, now + 0.28);

        osc.connect(gain);
        gain.connect(this.sfxGain);

        osc.start(now);
        osc.stop(now + 0.29);
    }

    /**
     * Victory Fanfare (Triumphant multi-voice celebration)
     */
    playVictory() {
        if (this.isSfxMuted) return;
        this.init();
        if (!this.ctx) return;

        // Temporarily duck BGM
        this.duckBgm(2.5);

        const now = this.ctx.currentTime;
        const fanfare = [
            { f: 523.25, t: 0.00, d: 0.16 }, // C5
            { f: 523.25, t: 0.16, d: 0.16 }, // C5
            { f: 523.25, t: 0.32, d: 0.16 }, // C5
            { f: 659.25, t: 0.48, d: 0.45 }, // E5
            { f: 783.99, t: 0.95, d: 0.25 }, // G5
            { f: 1046.50, t: 1.20, d: 1.20 }  // C6 (Grand sustain)
        ];

        fanfare.forEach(n => {
            const osc = this.ctx.createOscillator();
            const gain = this.ctx.createGain();

            osc.type = 'triangle';
            osc.frequency.setValueAtTime(n.f, now + n.t);

            gain.gain.setValueAtTime(0.35, now + n.t);
            gain.gain.exponentialRampToValueAtTime(0.001, now + n.t + n.d);

            osc.connect(gain);
            gain.connect(this.sfxGain);

            osc.start(now + n.t);
            osc.stop(now + n.t + n.d);
        });
    }

    /* -------------------------------------------------------------
     * DYNAMIC BACKGROUND MUSIC (BGM)
     * ----------------------------------------------------------- */

    /**
     * Start adaptive procedural background music.
     * @param {'quiz'|'project'} mode 
     */
    startBgm(mode = 'quiz') {
        this.init();
        if (!this.ctx) return;

        if (this.bgmInterval && this.currentBgmMode === mode) {
            return; // Already playing same mode
        }

        this.stopBgm();
        this.currentBgmMode = mode;
        this.bgmStep = 0;

        const intervalMs = mode === 'project' ? 240 : 360; // 125 BPM (project) vs 83 BPM (quiz)

        this.bgmInterval = setInterval(() => {
            if (this.isBgmMuted) return;
            this._tickBgm(mode);
            this.bgmStep = (this.bgmStep + 1) % 16;
        }, intervalMs);
    }

    /**
     * Stop background music
     */
    stopBgm() {
        if (this.bgmInterval) {
            clearInterval(this.bgmInterval);
            this.bgmInterval = null;
        }
        this.currentBgmMode = null;
    }

    /**
     * Temporarily reduce BGM volume during fanfare
     */
    duckBgm(seconds = 2.0) {
        if (!this.bgmGain || this.isBgmMuted) return;
        const now = this.ctx.currentTime;
        this.bgmGain.gain.cancelScheduledValues(now);
        this.bgmGain.gain.setValueAtTime(0.03, now);
        this.bgmGain.gain.exponentialRampToValueAtTime(0.18, now + seconds);
    }

    /**
     * Update dynamic music intensity (0.0 to 1.0)
     */
    setIntensity(progress) {
        this.bgmIntensity = Math.max(0.1, Math.min(1.0, progress));
    }

    /**
     * Procedural sequencer tick
     */
    _tickBgm(mode) {
        if (!this.ctx || this.ctx.state !== 'running') return;
        const now = this.ctx.currentTime;

        if (mode === 'project') {
            this._synthesizeProjectPattern(now, this.bgmStep);
        } else {
            this._synthesizeQuizPattern(now, this.bgmStep);
        }
    }

    /**
     * Regular Quiz BGM: Chill Coding Flow (Lo-Fi Chiptune / Relaxing Synth)
     */
    _synthesizeQuizPattern(now, step) {
        // 4 Chords: Cmaj7 -> Am7 -> Fmaj7 -> G7 (4 steps each)
        const chordIndex = Math.floor(step / 4);
        const subStep = step % 4;

        const chords = [
            [261.63, 329.63, 392.00, 493.88], // Cmaj7 (C4, E4, G4, B4)
            [220.00, 261.63, 329.63, 392.00], // Am7 (A3, C4, E4, G4)
            [174.61, 220.00, 261.63, 329.63], // Fmaj7 (F3, A3, C4, E4)
            [196.00, 246.94, 293.66, 349.23]  // G7 (G3, B3, D4, F4)
        ];

        const bassNotes = [130.81, 110.00, 87.31, 98.00]; // C3, A2, F2, G2

        // Soft Bass Pulse on step 0 and 2
        if (subStep === 0 || subStep === 2) {
            const osc = this.ctx.createOscillator();
            const gain = this.ctx.createGain();
            osc.type = 'triangle';
            osc.frequency.setValueAtTime(bassNotes[chordIndex], now);
            gain.gain.setValueAtTime(0.12, now);
            gain.gain.exponentialRampToValueAtTime(0.001, now + 0.32);
            osc.connect(gain);
            gain.connect(this.bgmGain);
            osc.start(now);
            osc.stop(now + 0.34);
        }

        // Ambient Pad Harmonic Note
        const activeChord = chords[chordIndex];
        const noteFreq = activeChord[subStep];
        const padOsc = this.ctx.createOscillator();
        const padGain = this.ctx.createGain();
        const filter = this.ctx.createBiquadFilter();

        filter.type = 'lowpass';
        filter.frequency.setValueAtTime(600 + this.bgmIntensity * 400, now);

        padOsc.type = 'sine';
        padOsc.frequency.setValueAtTime(noteFreq, now);

        padGain.gain.setValueAtTime(0.06 * (0.8 + this.bgmIntensity * 0.4), now);
        padGain.gain.exponentialRampToValueAtTime(0.001, now + 0.34);

        padOsc.connect(filter);
        filter.connect(padGain);
        padGain.connect(this.bgmGain);

        padOsc.start(now);
        padOsc.stop(now + 0.35);
    }

    /**
     * Mini Project BGM: Epic Tech Cyberpunk / Synthwave Boss Mode
     */
    _synthesizeProjectPattern(now, step) {
        // Minor Key High-Energy: Am -> F -> C -> G
        const chordIndex = Math.floor(step / 4);
        const subStep = step % 4;

        const bassFreqs = [110.00, 87.31, 130.81, 98.00]; // A2, F2, C3, G2
        const arpScales = [
            [440.00, 523.25, 659.25, 880.00], // Am (A4, C5, E5, A5)
            [349.23, 440.00, 523.25, 698.46], // F (F4, A4, C5, F5)
            [523.25, 659.25, 783.99, 1046.50],// C (C5, E5, G5, C6)
            [392.00, 493.88, 587.33, 783.99]  // G (G4, B4, D5, G5)
        ];

        // Punchy Cyber Bassline (16th-note groove)
        const bassOsc = this.ctx.createOscillator();
        const bassGain = this.ctx.createGain();
        const bassFilter = this.ctx.createBiquadFilter();

        bassOsc.type = 'sawtooth';
        bassOsc.frequency.setValueAtTime(bassFreqs[chordIndex], now);

        bassFilter.type = 'lowpass';
        bassFilter.frequency.setValueAtTime(380 + (subStep === 0 ? 300 : 100), now);
        bassFilter.Q.setValueAtTime(4.0, now);

        bassGain.gain.setValueAtTime(0.14, now);
        bassGain.gain.exponentialRampToValueAtTime(0.001, now + 0.22);

        bassOsc.connect(bassFilter);
        bassFilter.connect(bassGain);
        bassGain.connect(this.bgmGain);

        bassOsc.start(now);
        bassOsc.stop(now + 0.23);

        // Fast Dynamic Arpeggio Lead
        const arpNotes = arpScales[chordIndex];
        const arpFreq = arpNotes[(step * 2) % arpNotes.length];

        const arpOsc = this.ctx.createOscillator();
        const arpGain = this.ctx.createGain();

        arpOsc.type = 'triangle';
        arpOsc.frequency.setValueAtTime(arpFreq, now);

        arpGain.gain.setValueAtTime(0.08 * (0.6 + this.bgmIntensity * 0.6), now);
        arpGain.gain.exponentialRampToValueAtTime(0.001, now + 0.18);

        arpOsc.connect(arpGain);
        arpGain.connect(this.bgmGain);

        arpOsc.start(now);
        arpOsc.stop(now + 0.19);
    }

    /* -------------------------------------------------------------
     * CONTROLS & TOGGLES
     * ----------------------------------------------------------- */

    toggleSfx() {
        this.isSfxMuted = !this.isSfxMuted;
        localStorage.setItem('eduskill_sfx_muted', this.isSfxMuted);
        if (this.sfxGain && this.ctx) {
            this.sfxGain.gain.setValueAtTime(this.isSfxMuted ? 0 : 0.7, this.ctx.currentTime);
        }
        return !this.isSfxMuted;
    }

    toggleBgm() {
        this.isBgmMuted = !this.isBgmMuted;
        localStorage.setItem('eduskill_bgm_muted', this.isBgmMuted);
        if (this.bgmGain && this.ctx) {
            this.bgmGain.gain.setValueAtTime(this.isBgmMuted ? 0 : 0.18, this.ctx.currentTime);
        }
        return !this.isBgmMuted;
    }

    toggleAllSound() {
        const anyActive = !this.isSfxMuted || !this.isBgmMuted;
        if (anyActive) {
            this.isSfxMuted = true;
            this.isBgmMuted = true;
        } else {
            this.isSfxMuted = false;
            this.isBgmMuted = false;
        }
        localStorage.setItem('eduskill_sfx_muted', this.isSfxMuted);
        localStorage.setItem('eduskill_bgm_muted', this.isBgmMuted);

        if (this.ctx) {
            if (this.sfxGain) this.sfxGain.gain.setValueAtTime(this.isSfxMuted ? 0 : 0.7, this.ctx.currentTime);
            if (this.bgmGain) this.bgmGain.gain.setValueAtTime(this.isBgmMuted ? 0 : 0.18, this.ctx.currentTime);
        }

        return !this.isSfxMuted;
    }
}

// Global Singleton Instance
window.EduAudio = new EduAudioEngine();
window.SoundEngine = window.EduAudio; // Backward compatibility alias
