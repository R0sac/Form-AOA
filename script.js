$(document).ready(function() {
    var questions = [
        { question: "Quina és la teva ciutat favorita?", answers: ["Barcelona", "Madrid", "Valencia", "Sevilla"] },
        { question: "Quin és el teu color favorit?", answers: ["Verd", "Blau", "Vermell", "Groc"] },
        { question: "Quin és el teu esport favorit?", answers: ["Futbol", "Basket", "Tenis", "Natació"] }
      ];

      $('#contenido-crearpregunta, #contenido-crearencuesta, #contenido-listarpreguntas, #contenido-listarencuestas').hide();

    $('#crearPregunta').click(function() {
        $('#contenido-crearpregunta, #contenido-crearencuesta, #contenido-listarpreguntas, #contenido-listarencuestas').hide();
        $('#contenido-crearpregunta').show();
        document.getElementById("contenido-crearpregunta").innerHTML = "Aqui se crean preguntas";
    });
  
    $('#crearEncuesta').click(function() {
        $('#contenido-crearpregunta, #contenido-crearencuesta, #contenido-listarpreguntas, #contenido-listarencuestas').hide();
        $('#contenido-crearencuesta').show();
        document.getElementById("contenido-crearencuesta").innerHTML = "Aqui se crean encuestas";
    });
    
    $('#listarPreguntas').click(function() {
        $('#contenido-crearpregunta, #contenido-crearencuesta, #contenido-listarpreguntas, #contenido-listarencuestas').hide();
        $('#contenido-listarpreguntas').show();
        document.getElementById("contenido-listarpreguntas").innerHTML = "Aqui se listan las preguntas";
        /*
        $('#itempregunta').empty();
        for (var i = 0; i < questions.length; i++) {
        var question = questions[i];
        var questionItem = $('<li>').text(question.question);
        var answersList = $('<ul>');
        for (var j = 0; j < question.answers.length; j++) {
            var answer = question.answers[j];
            var answerItem = $('<li>').text(answer);
            answersList.append(answerItem);
        }
        questionItem.append(answersList);
        $('#itempregunta').append(questionItem);
        }
                <ul id="itempregunta"></ul>

        */
    });
    $('#listarEncuestas').click(function() {
        $('#contenido-crearpregunta, #contenido-crearencuesta, #contenido-listarpreguntas, #contenido-listarencuestas').hide();
        $('#contenido-listarencuestas').show();
        document.getElementById("contenido-listarencuestas").innerHTML = "Aqui se listan las encuestas";
    });
});

