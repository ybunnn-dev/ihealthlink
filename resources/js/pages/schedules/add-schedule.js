// The button that displays the selected program and opens the selection modal
const healthProgramButton = document.getElementById('healthProgramButton');

// The hidden input that stores the ID of the selected health program
const healthProgramIdInput = document.getElementById('healthProgramId');

// The button that displays the selected BHW and opens the selection modal
const bhwButton = document.getElementById('bhwButton');

// The hidden input that stores the ID of the selected BHW
const assignedBhwIdInput = document.getElementById('assignedBhwId');

// The <div> inside the program modal where the list of programs will be rendered
const programListContainer = document.getElementById('program-list-container');

// The <div> inside the BHW modal where the list of BHWs will be rendered
const bhwListContainer = document.getElementById('bhw-list-container');

// The "Add Activity" button that submits the form
const addActivitySubmitBtn = document.getElementById('add-activity-submit-btn');

// The "Cancel" button
const cancelActivityBtn = document.getElementById('cancel-activity-btn');