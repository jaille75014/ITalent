document.addEventListener('DOMContentLoaded', function() {
    var taskInput = document.getElementById('task');
    var addTaskBtn = document.getElementById('addTask');
    var taskList = document.getElementById('taskList');
  
    addTaskBtn.addEventListener('click', function() {
      var taskText = taskInput.value.trim();
      if (taskText !== '') {
        var taskItem = document.createElement('li');
        var checkBox = document.createElement('input');
        checkBox.type = 'checkbox';
        checkBox.addEventListener('change', function() {
          taskItem.style.textDecoration = this.checked ? 'line-through' : 'none';
        });
        var deleteBtn = document.createElement('button');
        deleteBtn.textContent = 'Supprimer';
        deleteBtn.addEventListener('click', function() {
          taskList.removeChild(taskItem);
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
        var tasks = result.tasks || [];
        tasks.push(task);
        chrome.storage.sync.set({tasks: tasks});
      });
    }
  
    chrome.storage.sync.get(['tasks'], function(result) {
      var tasks = result.tasks || [];
      tasks.forEach(function(task) {
        var taskItem = document.createElement('li');
        var checkBox = document.createElement('input');
        checkBox.type = 'checkbox';
        checkBox.addEventListener('change', function() {
          taskItem.style.textDecoration = this.checked ? 'line-through' : 'none';
        });
        var deleteBtn = document.createElement('button');
        deleteBtn.textContent = 'Supprimer';
        deleteBtn.addEventListener('click', function() {
          taskList.removeChild(taskItem);
        });
        taskItem.textContent = task;
        taskItem.appendChild(checkBox);
        taskItem.appendChild(deleteBtn);
        taskList.appendChild(taskItem);
      });
    });
})