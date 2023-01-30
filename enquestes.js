var idInputOptions = 0;
function removeAllAfterTitle(){
    $('#inputTitle').nextAll().remove();
    $('#btnAcceptar').remove();
}

function addAcceptButton(){
    $('#containerConfirmButtons').append(`
        <button class="btnConfirm btnAcceptar" id="btnAcceptar" >Acceptar</button>
    `);


    if ($('#formQuestion').length) {
        var questionType = Number($('#typeQuestion').val());
        $('#questionFormBDD').remove();

        switch (questionType) {
            case 1: //Pregunta Numérica

                $('#formQuestion').append(`
                    <form method="POST" action="./checkForm.php" id="questionFormBDD" hidden  style="display:none;">
                        <input type="text" name="typeOfForm" value="createQuestion" />
                        <input type="number" name="questionType" value="${questionType}" />
                        <input type="text" name="questionTitle" value="${$('#inputTitle').val()}" />
                    </form>
                `);

                if ($("#idQuestionEdit").length) {
                    $('#questionFormBDD').append(`
                        <input type="text" name="idQuestionEdit" id="idQuestionEdit" value="${$("#idQuestionEdit").val()}" hidden/>
                    `);
                }

                $('#btnAcceptar').click(()=>{
                    $('#questionFormBDD').submit();
                });   
                break;

            case 2: //Pregunta de Text

                $('#formQuestion').append(`
                    <form method="POST" action="./checkForm.php" id="questionFormBDD" hidden  style="display:none;">
                        <input type="text" name="typeOfForm" value="createQuestion" />
                        <input type="number" name="questionType" value="${questionType}" />
                        <input type="text" name="questionTitle" value="${$('#inputTitle').val()}" />
                    </form>
                `);

                if ($("#idQuestionEdit").length) {
                    $('#questionFormBDD').append(`
                        <input type="text" name="idQuestionEdit" id="idQuestionEdit" value="${$("#idQuestionEdit").val()}" hidden/>
                    `);
                }

                $('#btnAcceptar').click(()=>{
                    $('#questionFormBDD').submit();
                });   
                break;

            case 3:  //Pregunta d'Opció Simple


                $('#formQuestion').append(`
                    <form method="POST" action="./checkForm.php" id="questionFormBDD" hidden  style="display:none;">
                        <input type="text" name="typeOfForm" value="createQuestion" />
                        <input type="number" name="questionType" value="${questionType}" />
                        <input type="text" name="questionTitle" value="${$('#inputTitle').val()}" />
                    </form>
                `);
                
                for (let i = 0; i < $('.containerSingleRadioButtonWithOptions').length; i++) {
                    $('#questionFormBDD').append(`
                        <input type="text" name="inputOptions[${i}]" value="${$($('.textOption')[i]).val()}" />
                    `);
                }

                if ($("#idQuestionEdit").length) {
                    $('#questionFormBDD').append(`
                        <input type="text" name="idQuestionEdit" id="idQuestionEdit" value="${$("#idQuestionEdit").val()}" hidden/>
                    `);
                }

                $('#btnAcceptar').click(()=>{
                    $('#questionFormBDD').submit();
                });   
                break;
        }
    }
    else if ($('#formPoll').length){
        $('#pollFormBDD').remove();


        $('#btnAcceptar').click(()=>{
            $('#formPoll').append(`
                <form method="POST" action="./checkForm.php" id="pollFormBDD" hidden  style="display:none;">
                    <input type="text" name="typeOfForm" value="createPoll" />
                    <input type="text" name="pollTitle" value="${$('#inputTitle').val()}" />
                    <input type="text" name="inputStartDate" value="${$('#inputStartDate').val()}" />
                    <input type="text" name="inputEndDate" value="${$('#inputEndDate').val()}" />
                </form>
            `);
        
            // ADDING TEACHERS TO FORM
            for (let i = 0; i < $('#selectorSomeTeachers').children().length; i++) {
                var idTeacher = $($('#selectorSomeTeachers').children()[i]).attr('id').split("-")[1];
                $('#pollFormBDD').append(`
                    <input type="text" name="inputTeachersId[${i}]" value="${idTeacher}" />
                `);
            };

            // ADDING QUESTIONS TO FORM
            for (let i = 0; i < $('#selectorSomeQuestion').children().length; i++) {
                var fatherElementOfId = $($('#selectorSomeQuestion').children()[i]);
                var idQuestion = $(fatherElementOfId.children()[0]).attr('id').split("-")[1];

                $('#pollFormBDD').append(`
                    <input type="text" name="inputQuestionsId[${i}]" value="${idQuestion}" />
                `);
            };

            // ADDING STUDENTS TO FORM
            for (let i = 0; i < $('#selectorSomeStudent').children().length; i++) {
                var idStudent = $($('#selectorSomeStudent').children()[i]).attr('id').split("-")[1];
                $('#pollFormBDD').append(`
                    <input type="text" name="inputStudentsId[${i}]" value="${idStudent}" />
                `);
            };

            if ($("#idPollEdit").length) {
                $('#pollFormBDD').append(`
                    <input type="text" name="idPollEdit" id="idQuestionEdit" value="${$("#idPollEdit").val()}" hidden/>
                `);
            }
            $('#pollFormBDD').submit();
            
        });   
    }



}

function removeAcceptButton(){
    $('#btnAcceptar').remove();
}

function checkIfAllOptionsFilled(){
    removeAcceptButton(); 

    for (let i = 0; i < $('.textOption').length; i++) {
        if(!$( $('.textOption')[i] ).val()){
            return
        }
    }
    addAcceptButton();
}

function addExtraSimpleOption(){
    var idNumber = idInputOptions;
    $('#addOrDeleteOptionButtons').before(`
        <div class="containerSingleRadioButtonWithOptions" id="div-Option-${idNumber}">
            <input class="radioOption"  type="radio" onclick="this.checked = false;">
            <input class="textOption" type="text"/>
            <button type="button" id="btnRemoveOption-${idNumber}" class="btnRemoveOption"><i class="fa-solid fa-minus"></i></button>
        </div>
    `);
    $( $('.textOption')[$('.textOption').length - 1 ] ).on('input',() => {
        checkIfAllOptionsFilled();
    });

    
    $(`#btnRemoveOption-${idNumber}`).click(() => {
        removeExtraSimpleOption(idNumber);
    });
    idInputOptions +=1;
    checkIfAllOptionsFilled();
}

function removeExtraSimpleOption(idNumberDiv){

    
    if ($('.containerSingleRadioButtonWithOptions').length <= 2) {
        NewError("error", "Com a mínim has de tenir 2 opcions");
        return
    }
    
    $(`#div-Option-${idNumberDiv}`).remove();

    if ($('btnAcceptar')) {
        removeAcceptButton();
    }

    checkIfAllOptionsFilled();

}



function addViewOfSelectedTypeQuestion(){
    var tipusPregunta = Number($('#typeQuestion').val());
    var enunciatPregunta = $('#inputTitle').val();


    if (!tipusPregunta || !enunciatPregunta){
        removeAllAfterTitle();
        return;
    } 
    switch (tipusPregunta) {
        case 1:
            removeAllAfterTitle();
            arrayOptionsOfTypeNumber.forEach(option => {
                $('#formQuestion').append(`
                <div class="containerSingleRadioButton" id="containerSingleRadioButton">
                    <input type="radio" id="radioBtn-`+ option.id +`" onclick="this.checked = false;">
                    <label for="radioBtn-`+ option.id +`">`+option.text+`</label>
                </div>
                `);

            });

            addAcceptButton();
            break;

        case 2:
            removeAllAfterTitle();
            $('#formQuestion').append(`
                <textarea id="textareaExample" readonly></textarea>
            `);
            addAcceptButton();
            break;

        case 3:
            if (!$(".containerSingleRadioButtonWithOptions").length){
                var idNumber = idInputOptions;
                removeAllAfterTitle();
                $('#formQuestion').append(`

                    <div class="containerSingleRadioButtonWithOptions" id = "div-Option-${idNumber}">
                        <input class="radioOption" type="radio" onclick="this.checked = false;">
                        <input class="textOption" type="text"/>
                        <button type="button" id="btnRemoveOption-${idNumber}" class="btnRemoveOption" ><i class="fa-solid fa-minus"></i></button>
                    </div>
                    <div class="containerSingleRadioButtonWithOptions" id = "div-Option-${idNumber + 1}">
                        <input class="radioOption"  type="radio" onclick="this.checked = false;">
                        <input class="textOption" type="text"/>
                        <button type="button" id="btnRemoveOption-${idNumber + 1}" class="btnRemoveOption" ><i class="fa-solid fa-minus"></i></button>
                    </div>

                    <div id="addOrDeleteOptionButtons" class="addOrDeleteOptionButtons">
                        <button type="button" id="btnAddOption" class="btnAddOption"><i class="fa-solid fa-plus"></i></button>
                    </div>
                `);

                // Adding oninput function to check if are filled all inputs
                for (let i = 0; i < $('.textOption').length; i++) {
                    $( $('.textOption')[i] ).on('input',() => {
                        checkIfAllOptionsFilled();
                    });
                }

                $('#btnAddOption').click(() => {
                    addExtraSimpleOption();
                });

                $(`#btnRemoveOption-${idNumber}`).click(function() {
                    removeExtraSimpleOption(idNumber);
                });

                $(`#btnRemoveOption-${idNumber+1}`).click(function() {
                    removeExtraSimpleOption(idNumber+1);
                });
                idInputOptions += 2 ;
        }
        checkIfAllOptionsFilled();
            break;
    }


}

function checkQuestionPollFilled(){
    checkStudentPollFilled();

    if ( $('#selectorSomeQuestion').children().length > 0) {

        if ($(".containerStudents").length) return

        $('#formPoll').append(`
            <label><strong>Selecció d'Alumnes:</strong></label>

            <div class="containerStudents" >

                <div class="containerSingleStudentSelector">
                    <label>Alumnes escollits</label>
                    <div class="selectorStudents" id="selectorSomeStudent" >
                    </div>
                </div>

                <div class="containerSingleStudentSelector">
                    <label>Alumnes disponibles</label>
                    <div class="selectorStudents" id="selectorAllStudent" >
                    </div>
                </div>

            </div>

        `);

    arrayStudents.forEach(student => {
        $('#selectorAllStudent').append(`
            <div class="singleSelector" id="divStudent-`+ student.id + `">
                <button type="button" class="btnAddStudent" id="btnAddStudent-`+student.id+`" ><i class="fa-solid fa-arrow-left-long"></i></button>
                <p>`+ student.username +`</p>
            </div>
        `);
    
        $('#btnAddStudent-'+student.id).click(() => {
            addStudentToPickedList(student);
        });
    });

        return;
    }
    $($('.containerQuestions')[0]).nextAll().remove();
}

function checkStudentPollFilled(){
    removeAcceptButton();
    if ($('#selectorSomeStudent').children().length > 0) {
        if ("#btnAccept");
        addAcceptButton();
        return
    }
}

function addStudentToPickedList(arrayOfStudent){

    $(`#divStudent-`+arrayOfStudent.id).remove();

    $('#selectorSomeStudent').append(`
        <div class="singleSelector" id="divStudent-`+arrayOfStudent.id+`">
            <p>`+ arrayOfStudent.username +`</p>
            <button type="button" class="btnRemoveStudent" id="btnRemoveStudent-`+arrayOfStudent.id+`" ><i class="fa-solid fa-arrow-right-long"></i></button>
        </div>
    `);

    $('#btnRemoveStudent-'+arrayOfStudent.id).click(() => {
        removeStudentFromPickedList(arrayOfStudent);
    });

    checkStudentPollFilled();

}

function removeStudentFromPickedList(arrayOfStudent){
    $(`#divStudent-`+arrayOfStudent.id).remove();

    $('#selectorAllStudent').append(`
        <div class="singleSelector" id="divStudent-`+ arrayOfStudent.id + `">
            <button type="button" class="btnAddStudent" id="btnAddStudent-`+arrayOfStudent.id+`" ><i class="fa-solid fa-arrow-left-long"></i></button>
            <p>`+ arrayOfStudent.username +`</p>
        </div>
    `);

    $('#btnAddStudent-'+arrayOfStudent.id).click(() => {
        addStudentToPickedList(arrayOfStudent);
    });

    checkStudentPollFilled();

}

function checkTeacherPollFilled(){

    if ($('#inputTitle').val().length > 0 && $('#inputStartDate').val().length > 0 && $('#inputEndDate').val().length > 0 && $('#selectorSomeTeachers').children().length > 0) {
        
        if ($(".containerQuestions").length) return

        $('#formPoll').append(`
            <label><strong>Selecció de Preguntes:</strong></label>

            <div class="containerQuestions" >
                <div class="containerSingleQuestionSelector">
                    <label>Preguntes Escollides</label>
                    <div class="selectorQuestions" id="selectorSomeQuestion" >
                    </div>
                </div>

                <div class="containerSingleQuestionSelector">
                    <label>Preguntes Disponibles</label>
                    <div class="selectorQuestions" id="selectorAllQuestion" >
                    </div>
                </div>
            </div>

        `);

        arrayQuestions.forEach(question => {
            $('#selectorAllQuestion').append(`
                <div class="singleSelector" id="divTeacher-`+ question.id + `">
                    <button type="button" class="btnAddTeacher" id="btnAddTeacher-`+question.id+`" ><i class="fa-solid fa-arrow-left-long"></i></button>
                    <p>`+ question.text +`</p>
                </div>
            `);
        
            $('#btnAddTeacher-'+question.id).click(() => {
                addQuestionToPickedList(question);
            });
        });
        return
    };
    $($('.containerTeachers')[0]).nextAll().remove();

}

function addQuestionToPickedList(question){
    var idQuestionPicked = idInputOptions;
    $('#selectorSomeQuestion').append(`
        <div class="singleSelector" id="divQuestion-${idQuestionPicked}">
            <p id="questionId-${question.id}"> ${question.text} </p>
            <button type="button" class="btnRemoveQuestion" id="btnRemoveQuestion-${idQuestionPicked}" ><i class="fa-solid fa-trash"></i>
            </button>
        </div>
    `);

    $(`#btnRemoveQuestion-${idQuestionPicked}`).click(function () {
        // $(this).parent(`#divQuestion-`+question.id).remove();
        $(`#btnRemoveQuestion-${idQuestionPicked}`).parent(`#divQuestion-${idQuestionPicked}`).remove();
        checkQuestionPollFilled();
        checkStudentPollFilled();

    });
    checkQuestionPollFilled();
    checkStudentPollFilled();
    idInputOptions += 1;
};

function removeTeacherFromPickedList(arrayOfTeacher){
    $(`#divTeacher-`+arrayOfTeacher.id).remove();

    $('#selectorAllTeachers').append(`
        <div class="singleSelector" id="divTeacher-`+ arrayOfTeacher.id + `">
            <button type="button" class="btnAddTeacher" id="btnAddTeacher-`+arrayOfTeacher.id+`" ><i class="fa-solid fa-arrow-left-long"></i></button>
            <p>`+ arrayOfTeacher.username +`</p>
        </div>
    `);

    $('#btnAddTeacher-'+arrayOfTeacher.id).click(() => {
        addTeacherToPickedList(arrayOfTeacher);
    });

    checkTeacherPollFilled();
    checkStudentPollFilled();

}


function addTeacherToPickedList(arrayOfTeacher){

    $(`#divTeacher-`+arrayOfTeacher.id).remove();

    $('#selectorSomeTeachers').append(`
        <div class="singleSelector" id="divTeacher-`+arrayOfTeacher.id+`">
            <p>`+ arrayOfTeacher.username +`</p>
            <button type="button" class="btnRemoveTeacher" id="btnRemoveTeacher-`+arrayOfTeacher.id+`" ><i class="fa-solid fa-arrow-right-long"></i></button>
        </div>
    `);

    $('#btnRemoveTeacher-'+arrayOfTeacher.id).click(() => {
        removeTeacherFromPickedList(arrayOfTeacher);
    });

    checkTeacherPollFilled();
    checkStudentPollFilled();

}

function editQuestion(question){
    createQuestion('#pollContent',arrayTypesOfQuestion);
    $("#typeQuestion").val(question.idTypeQuestion);
    $("#typeQuestion").prop("disabled",true);
    $("#inputTitle").val(question.text);
    $("#formQuestion").prepend(`
        <input type="text" id="idQuestionEdit" value="${question.id}" hidden/>
    `);
    addViewOfSelectedTypeQuestion();
    if (Number(question.idTypeQuestion) === 3 ) {  //singleOption questions
        for (let i = 0; i < arrayQuestionOption[question.id].length; i++) {
            var textOfInput = "";
            if (i > 1) {
                addExtraSimpleOption();
            }
            for (let j = 0; j < arrayOptions.length; j++) {
                if (Number(arrayOptions[j].id) ===  Number(arrayQuestionOption[question.id][i])) {
                    textOfInput = arrayOptions[j].text;
                }
            }

            $($($(".containerSingleRadioButtonWithOptions")[i]).children()[1]).val(textOfInput);
        }

    }
    checkIfAllOptionsFilled();

}

function removeQuestion(question){
    $('body').append(`
        <dialog id="modalDelete">
            <div class="titleDialog">
                <h2>Vols esborrar la pregunta: "${question.text}" ?</h2>
            </div>
            <h3>Al fer click en Esborrar, esborrarás la pregunta. Tot i així en les enquestes on es trobi la pregunta romandrá</h3>
            <div class="buttonsRemove">
                <button id="btnCancelDelete">Cancel·lar</button>
                <button id="btnAcceptDelete" >Esborrar</button>
            </div>
        </dialog>
    `);

    $('#btnCancelDelete').click(() => {
        $("#modalDelete").remove();
    });

    $('#btnAcceptDelete').click(() => {
        $("#pollContent").append(`
            <form id="formRemoveQuestion" action="./checkForm.php" method="POST" hidden>
                <input type="text" name="removeElement" value="question" />
                <input type="text" name="removeIdQuestion" value="${question.id}" />
            </form>
        `);

        $("#formRemoveQuestion").submit();


        $("#modalDelete").remove();
    });

    const modal = $("#modalDelete").get(0);
    modal.showModal();
    
}

function editPoll(poll){
    createPoll('#pollContent',arrayQuestions, arrayTeachers, arrayStudents);
    $("#inputTitle").val(poll.title);


    var startDate = new Date(poll.startDate.replace(/-/g,"/"));
    var dd = String(startDate.getDate()).padStart(2, '0');
    var mm = String(startDate.getMonth() + 1).padStart(2, '0');
    var yyyy = startDate.getFullYear();
    startDate =  yyyy + '-' + mm + '-' + dd;
    $("#inputStartDate").val(startDate);

    var endDate = new Date(poll.endDate.replace(/-/g,"/"));
    var dd = String(endDate.getDate()).padStart(2, '0');
    var mm = String(endDate.getMonth() + 1).padStart(2, '0');
    var yyyy = endDate.getFullYear();
    endDate =  yyyy + '-' + mm + '-' + dd;

    $("#inputEndDate").val(endDate);

    for (let i = 0; i < arrayPollTeacher[poll.id].length; i++) {
        for (let j = 0; j < arrayTeachers.length; j++) {
            if (Number(arrayTeachers[j].id) ===  Number(arrayPollTeacher[poll.id][i])) {
                addTeacherToPickedList(arrayTeachers[j]);
            }
        }
    }      
    checkTeacherPollFilled();

    for (let i = 0; i < arrayPollQuestion[poll.id].length; i++) {
        for (let j = 0; j < arrayQuestions.length; j++) {
            if (Number(arrayQuestions[j].id) ===  Number(arrayPollQuestion[poll.id][i])) {
                addQuestionToPickedList(arrayQuestions[j]);
            }
        }
    }      
    checkQuestionPollFilled();

    for (let i = 0; i < arrayPollStudent[poll.id].length; i++) {
        for (let j = 0; j < arrayStudents.length; j++) {
            if (Number(arrayStudents[j].id) ===  Number(arrayPollStudent[poll.id][i])) {
                addStudentToPickedList(arrayStudents[j]);
            }
        }
    }      
    checkStudentPollFilled();

    $("#formPoll").prepend(`
        <input type="text" name="idPollEdit" id="idPollEdit" value="${poll.id}" hidden/>
    `);

}

function removePoll(poll){
    $('body').append(`
        <dialog id="modalDelete">
            <div class="titleDialog">
                <h2>Vols esborrar l'enquesta: "${poll.title}" ?</h2>
            </div>
            <h3>Al fer click en Esborrar, esborrarás l'enquesta. Tot i així les enquestes actives romandrán fins que finalitzin</h3>
            <div class="buttonsRemove">
                <button id="btnCancelDelete">Cancel·lar</button>
                <button id="btnAcceptDelete" >Esborrar</button>
            </div>
        </dialog>
    `);

    $('#btnCancelDelete').click(() => {
        $("#modalDelete").remove();
    });

    $('#btnAcceptDelete').click(() => {
        $("#pollContent").append(`
            <form id="formRemovePoll" action="./checkForm.php" method="POST" hidden>
                <input type="text" name="removeElement" value="poll" />
                <input type="text" name="removeIdPoll" value="${poll.id}" />
            </form>
        `);

        $("#formRemovePoll").submit();


        $("#modalDelete").remove();
    });

    const modal = $("#modalDelete").get(0);
    modal.showModal();
    
}

//CREAR PREGUNTA
function createQuestion(elementDOM,arrayTextListQuestion){
    var fatherObjectJquery = $(elementDOM);
    fatherObjectJquery.empty();

    $('#btnCrearPregunta').addClass('active');
    
    $('#btnListarPreguntas').removeClass('active');
    $('#btnCrearEncuesta').removeClass('active');
    $('#btnListarEncuestas').removeClass('active');

    // Creacion de Formulario
    fatherObjectJquery.append(`
        <form class='formQuestion' id="formQuestion" method='POST'>
            <label for"typeQuestion">Tipus de pregunta:</label>
            <select class="typeQuestion" id="typeQuestion">
                <option value="0" disabled selected>Tria un tipus de pregunta</option>
            </select>

            <label for"inputTitle">Enunciat de la pregunta:</label>
            <input type="text" class="inputTitle" id="inputTitle">

        </form> 
        <div id="containerConfirmButtons" class="containerConfirmButtons" >
            <button class="btnConfirm btnCancelar" id="btnCancelar" >Cancel·lar</button>
        </div>
    `);

    // Creacion de dropdown
    arrayTextListQuestion.forEach(typeQuestion => {
        $('#typeQuestion').append(`
            <option value="`+ typeQuestion.id +`">
                `+typeQuestion.type+`
            </option>
        `);
    });

    $('#typeQuestion').change(() => {
        addViewOfSelectedTypeQuestion();
    });

    $('#inputTitle').on('input',() => {
        addViewOfSelectedTypeQuestion();
    });

    $('#btnCancelar').click(() => {
        fatherObjectJquery.empty();
        createQuestion(elementDOM,arrayTextListQuestion);
    });
    

}

// CREATE POLL
function createPoll(elementDOM, arrayQuestions, arrayTeachers){
    var fatherObjectJquery = $(elementDOM);
    fatherObjectJquery.empty();
    
    $('#btnCrearEncuesta').addClass('active');
    
    $('#btnListarPreguntas').removeClass('active');
    $('#btnCrearPregunta').removeClass('active');
    $('#btnListarEncuestas').removeClass('active');

    // Creacion de Formulario
    fatherObjectJquery.append(`
        <form class='formPoll' id="formPoll" method='POST'>
            <label for"inputTitle"><strong>Títol de l'enquesta:</strong></label>
            <input type="text" class="inputTitle" id="inputTitle">
            <div class="containerDates" >
                <div class="divSingleDate" >
                    <label for"inputStartDate"><strong>Data d'inici:</strong></label>
                    <input type="date" class="inputDate" id="inputStartDate">
                </div>

                <div class="divSingleDate" >
                    <label for"inputEndDate"><strong>Data final:</strong></label>
                    <input type="date"  class="inputDate" id="inputEndDate">
                </div>
            </div>

            <label><strong>Selecció de Professors:</strong></label>
            <div class="containerTeachers" >
                <div class="containerSingleTeacherSelector">
                    <label>Profesors Escollits</label>
                    <div class="selectorTeachers" id="selectorSomeTeachers" >
                    </div>
                </div>

                <div class="containerSingleTeacherSelector">
                    <label>Profesors Disponibles</label>
                    <div class="selectorTeachers" id="selectorAllTeachers" >
                    </div>
                </div>
            </div>

        </form> 
        <div id="containerConfirmButtons" class="containerConfirmButtons" >
            <button class="btnConfirm btnCancelar" id="btnCancelar" >Cancel·lar</button>
        </div>
    `);

    
    arrayTeachers.forEach(teacher => {
        removeTeacherFromPickedList(teacher)
    });


    $('#inputTitle').on('input',() => {
        checkTeacherPollFilled();
    });

    $('#inputStartDate').on('change',() => {
        checkTeacherPollFilled();
    });

    $('#inputEndDate').on('change',() => {
        checkTeacherPollFilled();
    });

    $('#btnCancelar').click(() => {
        fatherObjectJquery.empty();
        createPoll(elementDOM, arrayQuestions, arrayTeachers, arrayStudents);
    });
}

// LLISTAT DE PREGUNTES
function viewListQuestion(elementDOM,arrayTextListQuestion){
    var fatherObjectJquery = $(elementDOM);
    fatherObjectJquery.empty();

    $('#btnListarPreguntas').addClass('active');

    $('#btnCrearPregunta').removeClass('active');
    $('#btnCrearEncuesta').removeClass('active');
    $('#btnListarEncuestas').removeClass('active');

    fatherObjectJquery.append(`
    <table id="containerPolls" class="containerPolls">
            <tr>
                <th class ="textComponent" ><p>Preguntes</p></th>
                <th class="editComponent"><p>Accions</p></th>
            </tr>
        </table>
    `);
    
    var containerQuestions = $('#containerPolls tbody');

    arrayTextListQuestion.forEach(question => {
        containerQuestions.append(`
            <tr>
                <td class = "textComponent">` + question.text + `</td>
                <td class="editComponent">
                    <button class="editButton" id="editButton-${question.id}" ><i class="fa-solid fa-pencil"></i></button>
                    <button class="removeButton" id="removeButton-${question.id}" ><i class="fa-solid fa-trash"></i></button>
                </td>
            </tr>
        `);
                
        $(`#editButton-${question.id}`).click(() => {
            editQuestion(question);
        });

        $(`#removeButton-${question.id}`).click(() => {
            removeQuestion(question);
        });

    });

}
// LLISTAT D'ENQUESTES
function viewListPoll(elementDOM,arrayTitleListPoll){
    var fatherObjectJquery = $(elementDOM);
    fatherObjectJquery.empty();
    
    $('#btnListarEncuestas').addClass('active');

    $('#btnCrearPregunta').removeClass('active');
    $('#btnCrearEncuesta').removeClass('active');
    $('#btnListarPreguntas').removeClass('active');

    fatherObjectJquery.append(`
        <table id="containerPolls" class="containerPolls">
            <tr>
                <th class ="textComponent" ><p>Enquestes</p></th>
                <th class="editComponent"><p>Accions</p></th>
            </tr>
        </table>
    `);
    var containerPolls = $('#containerPolls tbody');

    arrayTitleListPoll.forEach(poll => {
        containerPolls.append(`
            <tr>
                <td class = "textComponent">` + poll.title + `</td>
                <td class="editComponent">
                    <button class="editButton" id="editButton-${poll.id}" ><i class="fa-solid fa-pencil"></i></button>
                    <button class="removeButton" id="removeButton-${poll.id}" ><i class="fa-solid fa-trash"></i></button>
                </td>
            </tr>
        `);
                
        $(`#editButton-${poll.id}`).click(() => {
            editPoll(poll);
        });

        $(`#removeButton-${poll.id}`).click(() => {
            removePoll(poll);
        });
    });
}