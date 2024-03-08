document.addEventListener('DOMContentLoaded', function(){
  // Get the button and modal
  let count = 0;
  const aiButton = document.getElementById("aiButton");
  const aiModal = document.getElementById("aiModal");
  const closeButton = document.getElementsByClassName("ai-modal-close")[0];
  const aiSubmit = document.getElementById('submitButton');
  const textInput = document.getElementById('textInput');

  // When the user clicks the button, show the modal
  aiButton.onclick = function() {
    aiModal.style.display = "block";
  }

  // When the user clicks on <span> (x), close the modal
  closeButton.onclick = function() {
    aiModal.style.display = "none";
  }

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == aiModal) {
      aiModal.style.display = "none";
    }
  }

  textInput.addEventListener('keyup', function (event){
    if (event.keyCode === 13){
    	event.preventDefault();
        submitText();
    }
  })

  // Handle submit button click
  aiSubmit.onclick = function() {
    submitText();
  }

  const submitText = function (){
    inputValue = textInput.value;
    ajax_handle_request(inputValue);
    count++;
  };

  const ajax_handle_request = function (quest){
    const aiResponse = document.getElementById('aiask-response');
    // create fields
    // const divQuest = createElement('div', 'aiask-quest', `ja-aiask-quest-${count}`, {'style': 'font-weight: bold;'}, '');
    const divQuest = createElement('div', 'aiask-quest', `ja-aiask-quest-${count}`, {}, '');
    const divResult = createElement('div', 'aiask-result', `ja-aiask-result-${count}`, {}, '');

    /*aiResponse.appendChild(divQuest);
    aiResponse.appendChild(divResult);*/
    aiResponse.insertAdjacentElement('afterend', divResult);
    aiResponse.insertAdjacentElement('afterend', divQuest);

    if (quest.length === 0){
      divQuest.innerText = 'Ask me something!';
      return ;
    }else {
      divQuest.innerText = inputValue;
    }
    const urlBase = Joomla.getOptions('system.paths');
    const urlParams = {
      option: 'com_ajax',
      plugin: 'jaaiask',
      format: 'json',
      aitask: 'ai_ask',
      quest: JSON.stringify(quest),
    };
    const paramString = new URLSearchParams(urlParams).toString().replace(/%2C/g, ',');
    const queryString = `${urlBase.base}/index.php?${paramString}`;
    fetch(queryString)
        .then(response => response.json())
        .then(d => {
          var data = d.data[0];
          if (data.code !== 200){
          	console.log(data.message);
          }else{
            handleRes(data.data, count-1);
          }
        })
        .catch(error => {
          console.log(`error: ${error}`);
        });
  };

  const handleRes = function (content, count){
    const result = document.getElementById(`ja-aiask-result-${count}`);
    result.innerText = content;
  };
})

function createElement(tagName, className, id, attributes, innerText) {
    const element = document.createElement(tagName);
    // Set class name
    if (className) {
      element.className = className;
    }
    // Set ID
    if (id) {
      element.id = id;
    }
    // Set custom attributes
    if (attributes) {
      for (const [key, value] of Object.entries(attributes)) {
        element.setAttribute(key, value);
      }
    }
    // Set inner text
    if (innerText) {
      element.innerText = innerText;
    }

    return element;
  }