document.addEventListener('DOMContentLoaded', function() {
  let taskInput = document.getElementById('task');
  let addTaskBtn = document.getElementById('addTask');
  let taskList = document.getElementById('taskList');
  let tasks = [];

  addTaskBtn.addEventListener('click', function() {
    let taskText = taskInput.value.trim();
    if (taskText !== '') {
      let taskItem = document.createElement('li');
      let checkBox = document.createElement('input');
      checkBox.type = 'checkbox';
      checkBox.addEventListener('change', function() {
        taskItem.style.textDecoration = this.checked ? 'line-through' : 'none';
      });
      let deleteBtn = document.createElement('button');
      deleteBtn.textContent = 'Supprimer';
      deleteBtn.addEventListener('click', function() {
        let taskIndex = tasks.indexOf(taskText);
        if (taskIndex > -1) {
          tasks.splice(taskIndex, 1);
        }
        chrome.storage.sync.set({tasks: tasks}, function() {
          taskList.removeChild(taskItem);
        });
      });
      taskItem.textContent = taskText;
      taskItem.appendChild(checkBox);
      taskItem.appendChild(deleteBtn);
      taskList.appendChild(taskItem);
      taskInput.value = '';
      saveTask(taskText);
    }
  });

  function saveTask(task) {
    chrome.storage.sync.get(['tasks'], function(result) {
      tasks = result.tasks || [];
      tasks.push(task);
      chrome.storage.sync.set({tasks: tasks});
    });
  }

  chrome.storage.sync.get(['tasks'], function(result) {
    tasks = result.tasks || [];
    tasks.forEach(function(task) {
      let taskItem = document.createElement('li');
      taskItem.className="list-group-item";
      let checkBox = document.createElement('input');
      checkBox.type = 'checkbox';
      checkBox.className="form-check-input ms-3";
      checkBox.addEventListener('change', function() {
        taskItem.style.textDecoration = this.checked ? 'line-through' : 'none';
      });
      let deleteBtn = document.createElement('button');
      deleteBtn.className="btn btn-danger btn-sm ms-5"
      deleteBtn.innerHTML = 'Supprimer';
      deleteBtn.addEventListener('click', function() {
        let taskIndex = tasks.indexOf(task);
        if (taskIndex > -1) {
          tasks.splice(taskIndex, 1);
        }
        chrome.storage.sync.set({tasks: tasks}, function() {
          taskList.removeChild(taskItem);
        });
      });
      taskItem.textContent = task;
      taskItem.appendChild(checkBox);
      taskList.appendChild(taskItem);
      taskItem.appendChild(deleteBtn);
    });
  });

  
});
