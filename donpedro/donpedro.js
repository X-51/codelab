var karramba = new Audio();
karramba.src = 'karramba.wav';
var spring = new Audio(); //sprezyna
spring.src = "spring.wav";
//
var lost = new Audio();
lost.src = "lost.wav";
//character image
var character = new Image();
character.src = "character.jpg";
var symbol = '<img id="character" src="character.jpg" alt="X" />';
//click sound
var sound = new Audio();
sound.src = "click.wav";
function walkSound() {
  sound.currentTime = 0;
  sound.play(); //plays sound on move
}
function springSound() {
  spring.currentTime = 0;
  spring.play(); //plays sound on move
}
function karrambaSound() {
  karramba.currentTime = 0;
  karramba.play(); //plays sound on move
}
karrambaSound();
//wall sound
var wall = new Audio();
wall.src = "wall.wav";
function wallSound() {
  wall.currentTime = 0;
  wall.play(); //plays sound on move
}
var bok = 9;
if (bok%2==0) bok++; //zmiana na liczbe nieparzysta - dodaje to komorke ktora jest na srodku
var srodek = Math.floor(bok/2);
//console.log(srodek);
var maxHor = bok-1;
var maxVert = bok-1;
var hor = [];
var vert = [];
var h=0,v=0;
for (i=0;i<bok*bok;i++) {
  hor.push(h);
  vert.push(v);
  var kostki = "";
  kostki += '<div class="kostka" id="'+h+"i"+v+'"></div>';
  h++;
  document.getElementById('container').innerHTML += kostki;
  if ((i+1)%bok==0)
  {
    h=0;
    v++;
    document.getElementById('container').innerHTML += '<div style="clear:both"></div>';
  }
}

var currentId = srodek+"i"+srodek;
var coords = [srodek,srodek];
document.getElementById(currentId).innerHTML += symbol;

var przegrales = false;
function hint() {
  document.getElementById('uzyjStrzalek').innerHTML = 'Użyj strzałek!';
  setTimeout(function() {document.getElementById('uzyjStrzalek').innerHTML = '';},500)
}

function checkKey(event) {
  if (przegrales==false) {
    switch(event.keyCode) {
      case 37:
      // Key left
      document.getElementById(coords[0]+"i"+coords[1]).innerHTML = '';
      if (coords[0]==0) {
        coords[0]=0;
        wallSound();
        document.getElementById(coords[0]+"i"+coords[1]).innerHTML = symbol;
      } else {
        walkSound();
        coords[0]--;
        document.getElementById(coords[0]+"i"+coords[1]).innerHTML = symbol;
      }
      break;
      case 38:
      // key up
      document.getElementById(coords[0]+"i"+coords[1]).innerHTML = '';
      if (coords[1]==0) {
        coords[1]=0;
        wallSound();
        document.getElementById(coords[0]+"i"+coords[1]).innerHTML = symbol;
      } else {
        walkSound();
        coords[1]--;
        document.getElementById(coords[0]+"i"+coords[1]).innerHTML = symbol;
      }
      break;
      case 39:
      // key right
      document.getElementById(coords[0]+"i"+coords[1]).innerHTML = '';
      if (coords[0]==maxHor) {
        coords[0]=maxHor;
        wallSound();
        document.getElementById(coords[0]+"i"+coords[1]).innerHTML = symbol;
      } else {
        walkSound();
        coords[0]++;
        document.getElementById(coords[0]+"i"+coords[1]).innerHTML = symbol;
      }
      break;
      case 40:
      // Key down
      document.getElementById(coords[0]+"i"+coords[1]).innerHTML = '';
      if (coords[1]==maxVert) {
        coords[1]=maxVert;
        wallSound();
        document.getElementById(coords[0]+"i"+coords[1]).innerHTML = symbol;
      } else {
        walkSound();
        coords[1]++;
        document.getElementById(coords[0]+"i"+coords[1]).innerHTML = symbol;
      }
      break;
      default:
      hint();
      break;
    }
  }
}
var enemy = new Image();
enemy.src = 'enemy.jpg';
var enemyCoords = [0,0];
var enemyPosition = document.getElementById(enemyCoords[0]+"i"+enemyCoords[1]).innerHTML = '<img id="enemy" src="enemy.jpg" alt="X" />';
var enemyHor = hor;
var enemyVert = vert;
var repeatId; // pozwala na zatrzymanie funkcji repeat();
var goniMnieSpeed = 1000; // czasomierz

/* funkcja do wywolania */
function goniMnie(speed) {
  if (goniMnieSpeed > 160) {goniMnieSpeed-=speed} else {
    console.log(goniMnieSpeed);};
    document.getElementById(enemyCoords[0]+"i"+enemyCoords[1]).innerHTML = '';
    if (coords[0]-enemyCoords[0] == 0) {
      var kierunek = 1;
    } else if (coords[1]-enemyCoords[1] == 0) {
      var kierunek = 0;
    } else {
      var kierunek = Math.round(Math.random());
    }
    switch(kierunek) {
      case 0:
      if (coords[0]-enemyCoords[0] !== 0) {
        if (coords[0]-enemyCoords[0] > 0) {
          enemyCoords[0]+=1;
        } else {
          enemyCoords[0]-=1;
        }
      }
      break;
      case 1:
      if (coords[1]-enemyCoords[1] !== 0)
      {
        if (coords[1]-enemyCoords[1] > 0) {
          enemyCoords[1]+=1;
        } else {
          enemyCoords[1]-=1;
        }
      }
      break;
    }
    document.getElementById(enemyCoords[0]+"i"+(enemyCoords[1])).innerHTML = '<img id="enemy" src="enemy.jpg" alt="X" />';
  };

  (function repeat() {
    repeatID = setTimeout(repeat, goniMnieSpeed); //funkcja, odstep czasowy
    goniMnie(10); //przyspieszaj o
  })();
  //clearTimeout(repeatID); //wywolaj te funkcje aby zatrzymac gonienie

  var warunekWygranej = setInterval(function(){
    //console.log('odstep');
    if (enemyCoords[0]==coords[0] && enemyCoords[1]==coords[1])
    {
      przegrales = true;
      przegrana();
      clearInterval(warunekWygranej);
    }
  },10);

  //mierzenie czasu rozgrywki
  var countID;
  var addSec = 10;
  var score = 0;
  function dodajCzas(dodaj) {
    score+=dodaj;
    var punktyTekst = "Punkty";
    document.getElementById('punktyTekst').innerHTML = punktyTekst;
    document.getElementById('punktyWartosc').innerHTML = score;
  }

  (function addTime() {
    countID = setTimeout(addTime,addSec);
    dodajCzas(1);
  })();


  function przegrana(przegrales) {
    clearInterval(goniMnie);
    clearTimeout(repeatID);
    clearTimeout(countID);
    document.getElementById('container').innerHTML = '<br /><div>Przegrałeś!</div><br /><div><a href="javascript:history.go(0);">Jeszcze raz!</a></div><br />';
    lost.play();
  }
