<script>
document.getElementById('reisForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const start = document.getElementById('start').value;
    const bestemming = document.getElementById('bestemming').value;

    const response = await fetch(`api.php?action=plan_route&from=${encodeURIComponent(start)}&to=${encodeURIComponent(bestemming)}`);
    const data = await response.json();

    if(data.error){
        document.getElementById('resultaat').innerHTML = `<p>${data.error}</p>`;
        return;
    }

    let html = `<h3>📅 Reisoverzicht</h3>`;
    html += `<p><strong>Van:</strong> ${data.from}</p>`;
    html += `<p><strong>Naar:</strong> ${data.to}</p>`;
    html += `<ul>`;
    data.legs.forEach(leg => {
        html += `<li>${leg.type} ${leg.line} van ${leg.from} (${leg.departure}) naar ${leg.to} (${leg.arrival})</li>`;
    });
    html += `</ul>`;
    document.getElementById('resultaat').innerHTML = html;
});
</script>
