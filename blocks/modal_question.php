<div id="modalQuestion" class="modal_question">
    <div class="modal_question-dialog">
        <div class="modal_question-content">
            <div class="modal_question-header">
                <h3 class="modal_question-title" style="font-size: 24px">Задать вопрос по проекту "<?= $card_name ?>"</h3>
                <span class="close" onclick="closeModalQuestion('modalQuestion')">&times;</span>   
            </div>
            <div class="modal_question-body">
                <div class="feedback_form">

                    <form id="ques" method="post">
                        <div class="inp">
                            <input required="required" id="user_name" type="text" name="NAME" size="60" maxlength="128" placeholder="Ваше имя *">
                            <input required="required" id="user_tel" type="text" name="PHONE" size="60" maxlength="128" placeholder="Ваш телефон *">
                            <input required="required" id="user_email" type="text" name="EMAIL" size="60" maxlength="128" placeholder="Email">

                            <input type="hidden" id="project_name" name="project_name" value='<?= $card_name; ?>'>

                            <textarea required="required" id="user_text" placeholder="Текст вашего сообщения" rows="6" name="TEXT"></textarea>
                        </div>                        
                        <div class="sub">
                            <input type="submit" value="ОТПРАВИТЬ" onclick="addFeedback(event, '<?php echo htmlspecialchars($card_name, ENT_QUOTES, 'UTF-8'); ?>')">
                        </div>
                    </form>

                    <div id="result" style="color: white; padding: 25px; font-size: 16px"></div>

                </div> 

            </div>
        </div>
    </div>
</div>
