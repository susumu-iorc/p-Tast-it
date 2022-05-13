<?php
function footSet(){
  $delete_pin = rand(100000,999999);
  echo <<< EOF
            <div id="deleteuser" class="modal js-modal">
              <div class="modal__bg js-modal-close"></div>
              <div class="modal__content">
                <p>アカウントを削除する場合以下の文字を入力してください</p>
                <p id="deletepin"><b>{$delete_pin}</b></p>
                <input onkeyup="deleteCheck()" type="text" id="typdeletepin" max="6">
                <button onclick="accountDelete({$delete_pin})" id="deletebutton" style="display:none" >アカウントを削除</button><br>
                <button class="js-modal-close" href="">やめる</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer>
        <p><small><a target="" href="/tastit/privacy-poricy.html">プライバシーポリシー</a></small></p>
        <p><small>&copy; 2022 <a target="_blank" href="#">Tast-it</a></small></p>
      </footer>
    </body>
  </html>
  EOF;
}
