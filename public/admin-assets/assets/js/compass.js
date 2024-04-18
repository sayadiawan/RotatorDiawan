// normalize degrees value trim in range: 0-360
const normalizeDeg = function (d = 0) {
    if (d && typeof d === 'number') {
        d = parseInt(d);
        if (d) {
            return (360 + (d % 360)) % 360;
        }
    }
    return 0;
}
// set value of current heading
const currentHeading = function (h = 0) {
    if (h && typeof h === 'number') {
        h = parseInt(h);
        if (h) {
            return 360 - normalizeDeg(h);
        }
    }
    return 0;
}
// apply heading values setting by knob
const applyHDG = (hdg, self) => {
    let lhdg = hdg == 0 ? 360 : hdg;
    let diff = self.prevhdg - lhdg;
    let mdiff = Math.abs(diff % 360);
    let sign = mdiff < 180 ? 1 : -1;
    let res = (mdiff < 180 ? mdiff : 360 - mdiff);
    // set compass rotation angle
    let deg = currentHeading(hdg);
    self.hdg = deg;
}
// compass gauge class
class HDGGauge {
    #hdg;
    #prevhdg;
    #container;
    #headingDiv;
    #compassDiv;
    #compassRotatingDiv;    // needle and rotating gauge face
    constructor(hdg = 0) {
        this.#container = document.querySelector('.container');
        this.#headingDiv = document.querySelector('.heading');
        this.#compassDiv = document.querySelector('.compass');
        this.#compassRotatingDiv = document.querySelector('.moving');
        this.hdg = normalizeDeg(hdg);
        this.prevhdg = this.hdg;
    }
    get hdgDiv() { return this.#headingDiv; }
    get needleDiv() { return this.#compassRotatingDiv; }
    get hdg() { return this.#hdg; }
    set hdg(v = 0) {
        let self = this;
        let hdg = normalizeDeg(v);
        let deg = (360 - hdg);
        if ((360 - deg) == 0) {
            deg = 0;    // avoids 360 degrees on heading indicator
        }
        self.hdgDiv.innerHTML = deg.toString().padStart(3, "0");
        degrees =  deg.toString().padStart(3, "0");
        self.needleDiv.style.transform = `rotate(${360 - currentHeading(hdg)}deg)`;
    }
    get prevhdg() { return this.#prevhdg; }
    set prevhdg(v = 0) {
        return this.#prevhdg = normalizeDeg(v);
    }
    get compassdiv() { return this.#container };
}
// knob event handlers
const knobPush = (evt, currheading, self) => {
    let nodes = Array.prototype.slice.call(evt.composedPath()),
        gear = self.knob;
    if (nodes.indexOf(gear) >= 0) {
        self.pressed = true;
        if (evt.button == 2) {
            applyHDG(0, self);              // reset to 000
            knobReset(self.prevhdg, self);  // reset knob default
        } else if (evt.button == 0) {
            self.start = {
                x: evt.clientX,
                y: evt.clientY
            };
            self.prevpos = { x: evt.offsetX, y: evt.offsetY };
            self.prevdist = { dx: 0, dy: 0 };
        }
    }
}

const knobPushAndRotate = (evt, prevhdg, self) => {
    let isPressed = self.pressed;
    if (isPressed === true) {
        let step = evt.movementX;
        let direction = evt.clientX - self.prevpos.x;
        let sign = (direction < 0 ? -1 : 1);
        let currhdg = self.hdg
        let prevhdg = self.prevhdg
        if (direction) {
            // self.deg += sign;
            if (step < 0) {
                step = (step < -self.stepmax) ? -self.stepmax : step;
            } else {
                step = step > self.stepmax ? self.stepmax : step;
            }
            self.deg += step;
            if (self.deg + sign) {
                applyHDG(self.deg, self); // rotate compass
                // rotate knob
                self.knob.style.transform = `rotate(${self.deg}deg)`;
            }
        }
        self.prevpos.x = evt.clientX;
    }
}

const knobReset = (prevhdg, self) => {
    let isPressed = self.pressed;
    let sign = Math.abs(self.prevhdg - self.hdg) > 180 ? 1 : -1;
    if (isPressed === true) {
        self.deg = 0;
        self.deg *= sign;
        self.knob.style.transform = `rotate(${self.deg}deg)`;
        self.prevpos.x = 0;
    }
}

const knobRelease = (evt, currheading, self) => {
    self.pressed = false;
    let isPressed = self.pressed;
    self.prevpos.x = 0;
}

class HDGknob extends HDGGauge {
    #stepmax = 4;   // how sensitive is the knob during rotation
    #messagesDiv;
    #knob;
    #turndirection = 0;
    #knobarea;
    #knobpressed = false;
    #knobrotate = false;
    #start;
    #prevpos= {x: 0, y: 0};
    #prevdist = {dx: 0, dy: 0};
    constructor(hdg = 0) {
        super(hdg);
        this.#knobarea = document.querySelector('.gear-container');
        this.#knob = document.querySelector('.gear');
        this.init();
        this.deg = 0;
    }
    init() {
        document.addEventListener('mousedown', (evt) => knobPush(evt, this.hdg, this), false);
        document.addEventListener('mousemove', (evt) => knobPushAndRotate(evt, this.prevhdg, this), false);
        document.addEventListener('mouseup', (evt) => knobRelease(evt, this.hdg, this), false);
    }
    get stepmax() { return this.#stepmax; }
    get knobarea() { return this.#knobarea; }
    get knob() { return this.#knob; }
    get pressed() { return this.#knobpressed; }
    set pressed(v = false) {
        return this.#knobpressed = v;
    }
    get gear() { return this.#knob; }
    set start(pos = { x: 0, y: 0 }) { return this.#start = pos; }
    get start() {
        return this.#start;
    }
    set prevpos(pos = {
        x: 0,
        y: 0
    }) {
        return this.#prevpos = pos;
    }
    get prevpos() {
        return this.#prevpos;
    }
    get previdst() { return this.#prevdist; }
    set prevdist(v = {dx: 0, dy: 0}) { return this.#prevdist = v; };
}

window.onload = ((w, d) => {
    let hdgknob = new HDGknob(0);
    document.addEventListener('mousemove', (evt) =>{
        var degrees=360 - normalizeDeg(hdgknob.deg);
        console.log(degrees);
        
        if (degrees<=36 || degrees ==360) {
            degrees=0;
            
        } else if (degrees>36 && degrees <=72) {
            degrees=1;
            
        }else if (degrees>72 && degrees <=108) {
            degrees=2;
            
        }else if (degrees>108 && degrees <=144) {
            degrees=3;
            
        }else if (degrees>144 && degrees <=180) {
            degrees=4;
            
        }else if (degrees>180 && degrees <=216) {
            degrees=5;
            
        }else if (degrees>216 && degrees <=252) {
            degrees=6;
            
        }else if (degrees>252 && degrees <=288) {
            degrees=7;
            
        }else if (degrees>288 && degrees <=324) {
            degrees=8;
            
        }else if (degrees>324 &&degrees <360) {
            degrees=9;
            
        }
         $('#angle-view1').find("img[data-id='"+degrees+"']").css('display', 'inline');
         $('#angle-view1').find("img[data-id!='"+degrees+"']").css('display', 'none');
        $('#angle-view1').attr('data-current', degrees);
        currentImage = degrees;

    },);
})(window, document);
