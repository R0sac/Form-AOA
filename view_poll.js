function printQuestion(idOption, array) {
    for (let i=idOption; i < array.length; i++) {

        if (array[i].idTypeQuestion == 1) {
            if ( $(`[name=${array[i].idQuestion}]`).length) return
            $(`#formViewPoll`).append(`
                <h3>${array[i].question}</h3>
                <div class="containerSingleRadioButton" id="containerSingleRadioButton">
                    <input type="radio" name="${array[i].idQuestion}" value="${array[i].id}">
                    <label for="radioBtn">${array[i].text}</label>
                </div>
                <div class="containerSingleRadioButton" id="containerSingleRadioButton">
                    <input type="radio" name="${array[i+1].idQuestion}"  value="${array[i+1].id}">
                    <label for="radioBtn">${array[i+1].text}</label>
                </div>
                <div class="containerSingleRadioButton" id="containerSingleRadioButton">
                    <input type="radio" name="${array[i+2].idQuestion}"  value="${array[i+2].id}">
                    <label for="radioBtn">${array[i+2].text}</label>
                </div>
                <div class="containerSingleRadioButton" id="containerSingleRadioButton">
                    <input type="radio" name="${array[i+3].idQuestion}"  value="${array[i+3].id}">
                    <label for="radioBtn">${array[i+3].text}</label>
                </div>
                <div class="containerSingleRadioButton" id="containerSingleRadioButton">
                    <input type="radio" name="${array[i+4].idQuestion}"  value="${array[i+4].id}">
                    <label for="radioBtn">${array[i+4].text}</label>
                </div>
            `);
            i+= 5;
            if (i == (array.length)) {

                $(`[name=${array[i-5].idQuestion}]`).click(function(){
                    if ($("#btnSubmitAnswers").length) return

                    $(`#formViewPoll`).append(`
                    <br>
                    <input name="pollAnswer" type="text" value="${array[i-1].idPoll}" hidden/>
                    <input name="idStudent" type="text" value="${array[i-1].userId}" hidden/>
                    <button id="btnSubmitAnswers" type="submit">Enviar enquesta</button>
                    `);
                });
            }
            else{
                $(`[name=${array[i-5].idQuestion}]`).click(function(){
                    printQuestion(i,array);
                });
            }

            return
        }
        else if(array[i].idTypeQuestion == 2){
            if ( $(`[name=${array[i].idQuestion}]`).length) return
            $(`#formViewPoll`).append(`
                <h3>${array[i].question}</h3>
                <textarea class="textAreaGeneral" name="${array[i].idQuestion}"></textarea>
            `);

            i+= 1;
            if (i == (array.length)) {

                $(`[name=${array[i-1].idQuestion}]`).bind('input propertychange', function() {
                    if ($("#btnSubmitAnswers").length) return
                    
                    $(`#formViewPoll`).append(`
                        <br>
                        <input name="pollAnswer" type="text" value="${array[i-1].idPoll}" hidden/>
                        <input name="idStudent" type="text" value="${array[i-1].userId}" hidden/>
                        <button id="btnSubmitAnswers" type="submit">Enviar enquesta</button>
                    `);
                });
            }
            else{
                $(`[name=${array[i-1].idQuestion}]`).bind('input propertychange', function() {
                    printQuestion(i,array);
                });
            }
            return

        }
        else if(array[i].idTypeQuestion == 3){
            if ( $(`[name=${array[i].idQuestion}]`).length) return
            $(`#formViewPoll`).append(`
                <h3>${array[i].question}</h3>
            `);
            var idToPrint = array[i].idQuestion;
            for (i; i < array.length; i++) {
                if (array[i].idQuestion == idToPrint) {
                    $(`#formViewPoll`).append(`
                        <div class="containerSingleRadioButton" id="containerSingleRadioButton">
                            <input type="radio" name="${array[i].idQuestion}"  value="${array[i].id}">
                            <label for="radioBtn">${array[i].text}</label>
                        </div>
                    `);
                }
                else{
                    break;
                }
            }

            if (i == (array.length)) {
                $(`[name=${idToPrint}]`).click(function(){
                    if ($("#btnSubmitAnswers").length) return
                    $(`#formViewPoll`).append(`
                    <br>
                    <input name="pollAnswer" type="text" value="${array[i-1].idPoll}" hidden/>
                    <input name="idStudent" type="text" value="${array[i-1].userId}" hidden/>
                    <button id="btnSubmitAnswers" type="submit">Enviar enquesta</button>
                `);
                });
            }
            else{
                $(`[name=${idToPrint}]`).click(function(){
                    printQuestion(i,array);
                });
            }

            return

        }
    }

}

function printQuestionReadOnly(idOption, array) {

    for (let i=idOption; i < array.length; i++) {

        if(array[i].idTypeQuestion == 2){
            
            $(`#formViewPoll`).append(`
                <h3>${array[i].question}</h3>
                <textarea id ="textAreaGeneral${array[i].idQuestion}" class="textAreaGeneral" name="${array[i].idQuestion}" readonly>
                </textarea>
            `);
            $(`#textAreaGeneral${array[i].idQuestion}`).val(array[i].answerText);

        }
        else if(array[i].idTypeQuestion == 3 || array[i].idTypeQuestion == 1){

            $(`#formViewPoll`).append(`
                <h3>${array[i].question}</h3>
            `);
            var idToPrint = array[i].idQuestion;
            for (i; i < array.length; i++) {
                if (array[i].idQuestion == idToPrint) {

                    if (array[i].id == array[i].optionChoosed) {
                        $(`#formViewPoll`).append(`
                        <div class="containerSingleRadioButton" id="containerSingleRadioButton">
                            <input type="radio" name="${array[i].idQuestion}" checked value="${array[i].id}">
                            <label for="radioBtn">${array[i].text}</label>
                        </div>
                    `);
                    }
                    else{
                        $(`#formViewPoll`).append(`
                            <div class="containerSingleRadioButton" id="containerSingleRadioButton">
                                <input type="radio" name="${array[i].idQuestion}" disabled  value="${array[i].id}">
                                <label for="radioBtn">${array[i].text}</label>
                            </div>
                        `);
                    }

                }
                else{
                    break;
                }
            }
            i -=1;     
        }
    }

}