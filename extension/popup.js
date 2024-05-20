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
        let taskIndex = tasks.findIndex(t => t.text === taskText);
        if (taskIndex > -1) {
          tasks[taskIndex].completed = this.checked;
          chrome.storage.sync.set({tasks: tasks});
        }
      });
      let deleteBtn = document.createElement('button');
      deleteBtn.textContent = 'Supprimer';
      deleteBtn.addEventListener('click', function() {
        let taskIndex = tasks.findIndex(t => t.text === taskText);
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
      let barre = document.createElement('hr');
      taskItem.appendChild(barre);
      taskInput.value = '';
      saveTask(taskText, checkBox.checked);
    }
  })

  function saveTask(task, isCompleted) {
    chrome.storage.sync.get(['tasks'], function(result) {
      tasks = result.tasks || [];
      tasks.push({ text: task, completed: isCompleted });
      chrome.storage.sync.set({tasks: tasks});
    });
  }

  chrome.storage.sync.get(['tasks'], function(result) {
    tasks = result.tasks || [];
    tasks.forEach(function(task) {
      let taskItem = document.createElement('li');
      let checkBox = document.createElement('input');
      checkBox.type = 'checkbox';
      checkBox.checked = task.completed;
      checkBox.addEventListener('change', function() {
        taskItem.style.textDecoration = this.checked ? 'line-through' : 'none';
        let taskIndex = tasks.findIndex(t => t.text === task.text);
        if (taskIndex > -1) {
          tasks[taskIndex].completed = this.checked;
          chrome.storage.sync.set({tasks: tasks});
        }
      });
      let deleteBtn = document.createElement('button');
      deleteBtn.innerHTML = 'Supprimer';
      deleteBtn.addEventListener('click', function() {
        let taskIndex = tasks.findIndex(t => t.text === task.text);
        if (taskIndex > -1) {
          tasks.splice(taskIndex, 1);
        }
        chrome.storage.sync.set({tasks: tasks}, function() {
          taskList.removeChild(taskItem);
        });
      });
      taskItem.textContent = task.text;
      taskItem.appendChild(checkBox);
      taskList.appendChild(taskItem);
      taskItem.appendChild(deleteBtn);
      let barre = document.createElement('hr');
      taskItem.appendChild(barre);
      taskItem.style.textDecoration = task.completed ? 'line-through' : 'none';
    });
  });
});