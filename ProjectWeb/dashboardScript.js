

const parkingAvailabilityChart = document.getElementById('parking-availability-chart').getContext('2d');
const parkingAvailabilityData = {
  labels: ['Available', 'Unavailable'],
  datasets: [{
    label: 'Parking Availability',
    data: [50, 50],
    backgroundColor: [
      'rgba(75, 192, 192, 0.2)',
      'rgba(255, 99, 132, 0.2)'
    ],
    borderColor: [
      'rgba(75, 192, 192, 1)',
      'rgba(255, 99, 132, 1)'
    ],
    borderWidth: 1
  }]
};

const parkingAvailabilityConfig = {
  type: 'doughnut',
  data: parkingAvailabilityData,
  options: {
    responsive: true,
    plugins: {
      legend: {
        position: 'top',
      },
      title: {
        display: true,
        text: 'Parking Availability'
      }
    }
  }
};

new Chart(parkingAvailabilityChart, parkingAvailabilityConfig);