const app= document.getElementById('typewriter')
;

const typewriterInstance = new Typewriter(app, {
    loop:true,
    delay:75,
});

typewriterInstance
.typeString('La forêt enchatée')
.pauseFor(200)
.start();