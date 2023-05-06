// <!-- Masking -->
    function formatCurrency(inputId) {
      // Retrieve the input field using its ID
      let inputField = document.getElementById(inputId);

      // Remove non-numeric characters from the input value
      let numericValue = inputField.value.replace(/\D/g, "");

      // Format the numeric value with the "Rp." prefix and thousands separators
      let formattedValue = `Rp. ${numericValue.replace(/\B(?=(\d{3})+(?!\d))/g, ".")}`;

      // Update the input field value with the formatted value
      inputField.value = formattedValue;
    }
    function formatNumber(inputId) {
      let inputField = document.getElementById(inputId);

      // Remove non-numeric characters from the input value
      let numericValue = inputField.value.replace(/\D/g, "");

      // Format the numeric value with the thousands separators
      let formattedValue = `${numericValue.replace(/\B(?=(\d{3})+(?!\d))/g, ".")}`;

      // Update the input field value with the formatted value
      inputField.value = formattedValue;
    }
    function formatAddress(inputId) {
      let inputField = document.getElementById(inputId);
    
      // Get the user input value
      let userInput = inputField.value.trim();
    
      // Check if the user input already has the "Jln." prefix
      let hasPrefix = userInput.startsWith("Jln.");
    
      // Format the numeric value with the "Jln." prefix and thousands separators if needed
      let formattedValue = hasPrefix ? userInput : `Jln. ${userInput}`;
    
      // Update the input field value with the formatted value
      inputField.value = formattedValue;
    }    
    function formatPercent(inputId) {
      let inputField = document.getElementById(inputId);

      // Remove non-numeric characters from the input value
      let numericValue = inputField.value.replace(/\D/g, "");

      // Format the numeric value with the thousands separators and "%" infix
      let formattedValue = `${numericValue} %`;

      // Update the input field value with the formatted value
      inputField.value = formattedValue;
    }