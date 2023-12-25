const mainDiv = document.querySelector(".main-div");
  const editor = document.querySelector("#editor");
  const characterCount = document.querySelector('#character-count');
  var currentCountvar = 0;

  function execCommand(command) {
    document.execCommand(command, false, null);
  }

  function toggleCommand(command) {
    editor.focus();
    document.execCommand(command, false, null);

    var buttons = document.querySelectorAll('#align-btn');
      buttons.forEach(function(button) {
        button.classList.remove('active-command-btn');
      });

    var isActive = document.queryCommandState(command);
    if (isActive) {
      document.querySelector('[onclick="toggleCommand(\'' + command + '\')"]').classList.add('active-command-btn');
      console.log(command + " is on");
    } else {
      document.querySelector('[onclick="toggleCommand(\'' + command + '\')"]').classList.remove('active-command-btn');
      console.log(command + " is off");
    }
  }

  function toggleList(command) {
    editor.focus();
    document.execCommand(command, false, null);
    var isActive = document.queryCommandState(command);
    
    if (isActive) {
      document.querySelector('[onclick="toggleList(\'' + command + '\')"]').classList.add('active-command-btn');
    } else {
      document.querySelector('[onclick="toggleList(\'' + command + '\')"]').classList.remove('active-command-btn');
    }
  }

  function updateCharacterCount(tmp) {
    
    if (editor && characterCount) {
      const currentCount = editor.textContent.length;
      
      if(tmp != 0){
        currentCount += tmp;
        console.log("uvecano za: " + tmp);
      } 
      var maxCount = parseInt(editor.getAttribute('maxlength'));

      if(currentCount <= maxCount) mainDiv.classList.remove('error-border');

      characterCount.textContent = currentCount + ' / ' + maxCount; 

    }
  }

  function onKeyDown(event) {
    /* Any Shortcut except Ctrl + V */
    const isValidShortcut = (event.ctrlKey && event.keyCode != 86 );

    /* Backspace - Delete - Arrow Keys - Ctrl - Shift */
    const isValidKeyCode = [8, 16, 17, 37, 38, 39, 40, 46].includes(event.keyCode);

    const maxLength = parseInt(event.srcElement.getAttribute("maxlength"));

    const text = event.srcElement.innerText;

    if ( text.length >= maxLength && !isValidKeyCode && !isValidShortcut ) {
      mainDiv.classList.add('error-border');
      event.preventDefault();
    }
    else if (event.keyCode == 9) {
      insertTab();
      updateCharacterCount(0);
      event.preventDefault();
    }
  }

function insertTab() {
  var editor = document.getElementById('editor');
  if (!editor || !window.getSelection) return;

  var sel = window.getSelection();
  if (!sel.rangeCount) return;

  var range = sel.getRangeAt(0);
  range.collapse(true);

  var span = document.createElement('span');
  span.appendChild(document.createTextNode('\t'));
  span.style.whiteSpace = 'pre';
  range.insertNode(span);

  range.setStartAfter(span);
  range.collapse(true);

  sel.removeAllRanges();
  sel.addRange(range);
}

var ce = document.querySelector('[contenteditable]')
  ce.addEventListener('paste', function (e) {
    e.preventDefault();
    var text = e.clipboardData.getData('text/plain');
    document.execCommand('insertText', false, text);
});


var backspaceBtn = document.querySelector('#backspace-btn');
backspaceBtn.addEventListener('click', function () {
    backspaceFunction();
});

function backspaceFunction() {
    if (currentCount > 0) {

        editor.textContent = editor.textContent.slice(0, -1);
        updateCharacterCount(0);
    }
}