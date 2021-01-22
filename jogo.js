tempo = 0; //variavel de tempo associada ao interval de 25ms
pontos = 0;
vida = 3;

telaX = 1000;
telaY = 450;

nome = null;

var jogador = {
    img1: new Image(),
    img2: new Image(),
    x: 30,
    y: 240,
    width: 38,
    height: 42
};
jogador.img1.src = "nave1.png";
jogador.img2.src = "nave2.png";
var alterna = false;

var tiro = {
    x: (jogador.x + 38),
    y: (jogador.y + 21),
    width: 15,
    height: 5,
    cor: 'red'
};
var disparos = [];

var inimigos = {
    img1: new Image(),
    img2: new Image(),
    height: 28,
    width: 38,
};
inimigos.img1.src = "inimigo1.png";
inimigos.img2.src = "inimigo2.png";
frota = [];
tempoInimigo = convSec(3);
velInimigo = 8; //5 pixels por 25 ms

var areaJogo = {
    canvas: document.createElement('canvas'),//criando a área do Jogo com o Canvas
    start: function(){ //gerando função que desenha as imagens no Canvas
        this.canvas.width = telaX;
        this.canvas.height = telaY;
        this.context = this.canvas.getContext('2d');
        document.body.insertBefore(this.canvas, document.body.childNodes[0]);
        this.interval = setInterval(atualizarFrame, 25);
        window.addEventListener('keydown', function(event){
            areaJogo.teclas = (areaJogo.teclas || []);
            areaJogo.teclas[event.key] = true;
        });
        window.addEventListener('keyup', function(event){
            areaJogo.teclas[event.key] = false;
        });
    },
    clear: function(){//gerando função que apaga tudo o que houver no Canvas
        this.context.clearRect(0,0, this.canvas.width, this.canvas.height);
    }
};

function convSec(segundos) {
    return (segundos*1000)/25;    
}

function checarAtaque(){
    for (var i in disparos){
        var disp = disparos[i];
        for (var j in frota){
            var inim = frota[j];
            if(disp.y > inim.y - tiro.height && disp.y < inim.y + inimigos.height){
                if(disp.x > inim.x && disp.x < inim.x + inimigos.width){
                    frota.splice(j, 1);
                    disparos.splice(i,1);
                    pontos += 30;
                    console.log('Acertou');
                }
            }
        }
    }
}
function checarDefesa(){
    for (var i in frota){
        var inim = frota[i];
        if(inim.y + inimigos.height > jogador.y && inim.y < jogador.y + jogador.height){
            if(jogador.x > inim.x && jogador.x < inim.x + inimigos.width){
                if(vida > 1){
                    frota.splice(i, 1);
                    document.getElementById('n'+vida).remove();
                    vida--; 
                } else{
                    document.getElementById('n'+vida).remove();
                    clearInterval(areaJogo.interval);
                    window.location.href = 'derrota.php?nome='+nome+'&pontos='+pontos;
                }
            }
        }
    }
}

function iniciar(usuario){
    nome = usuario;
    areaJogo.start();
    ctx = areaJogo.context;
    ctx.drawImage(jogador.img1, jogador.x, jogador.y, jogador.width, jogador.height);
}

function atualizarFrame(){
    areaJogo.clear();
    tempo++;
    if(tempo % 15 == 0) pontos++;
    document.getElementById('pontos').innerHTML = pontos;
    ctx = areaJogo.context;
    if(areaJogo.teclas){
        if(areaJogo.teclas['ArrowUp'] && jogador.y > 20) jogador.y -= 5;
        if(areaJogo.teclas['ArrowDown'] && jogador.y < telaY-60) jogador.y += 5;
        if(areaJogo.teclas['ArrowRight'] && jogador.x < 400) jogador.x += 5;
        if(areaJogo.teclas['ArrowLeft'] && jogador.x > 20) jogador.x -= 5;
        if(areaJogo.teclas[' ']){
            if(disparos.length > 0){
                if(tempo - disparos[disparos.length - 1].tempoDisp > 5){
                    disparos.push({
                        x: jogador.x + 38,
                        y: jogador.y + 19,
                        tempoDisp: tempo
                    });
                }
            } else{
                disparos.push({
                    x: jogador.x + 38,
                    y: jogador.y + 19,
                    tempoDisp: tempo
                });
            }
        }
    }
    if(tempo %50 == 0){
        frota.push({
            x: 1001,
            y: Math.floor(Math.random()*(telaY - 60)) + 20,
            vel: velInimigo
        });
        console.log('criado');
    }
    for (var i in disparos){
        var disp = disparos[i];
        if(disp.x >  1020) disparos.shift();
        else{
            ctx.fillStyle = tiro.cor;
            ctx.fillRect(disp.x, disp.y, tiro.width, tiro.height);
            disp.x += 15;
        }
    }
    for (var i in frota){
        var inim = frota[i];
        if(inim.x <  -40){
            frota.shift();
        } else{
            if(tempo%2 == 0) ctx.drawImage(inimigos.img1, inim.x, inim.y, inimigos.width, inimigos.height);
            else  ctx.drawImage(inimigos.img2, inim.x, inim.y, inimigos.width, inimigos.height);
            inim.x -= inim.vel;
        }
    }
    checarAtaque();
    checarDefesa();

    if(tempo%5 == 0) alterna = !alterna;
    
    if(alterna) ctx.drawImage(jogador.img1, jogador.x, jogador.y, jogador.width, jogador.height);
    else ctx.drawImage(jogador.img2, jogador.x, jogador.y, jogador.width, jogador.height);

    if(tempo%convSec(5) == 0 && tempoInimigo > convSec(0.5)) tempoInimigo--;
    if(tempo%convSec(10) == 0 && velInimigo < 35) velInimigo++;
}