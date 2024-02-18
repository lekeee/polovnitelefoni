generatePieGraph('donutCanvas', {
    values: [150, 50, 20, 85, 30],
    colors: ['#4CAF50', '#00BCD4', '#E91E63', '#FFC107', '#9E9E9E'],
    animation: true,
    animationSpeed: 2,
    doughnutHoleSize: null,
    doughnutHoleColor: '#fff',
    offset: 1,
    pie: 'normal',
    isStrokePie: {
        stroke: 20,
        overlayStroke: true,
        overlayStrokeColor: '#eee',
        strokeStartEndPoints: 'Yes',
        strokeAnimation: true,
        strokeAnimationSpeed: 40,
        fontSize: '60px',
        textAlignement: 'center',
        fontFamily: 'Arial',
        fontWeight: 'bold'
    }
});