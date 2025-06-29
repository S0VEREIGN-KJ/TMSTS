const departmentSelect = document.getElementById('department');
const barangaySelect = document.getElementById('barangay');

departmentSelect.addEventListener('change', () => {
  if (departmentSelect.value !== '') {
    barangaySelect.required = false;
    departmentSelect.required = true;
  }
});

barangaySelect.addEventListener('change', () => {
  if (barangaySelect.value !== '') {
    departmentSelect.required = false;
    barangaySelect.required = true;
  }
});