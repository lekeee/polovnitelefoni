function generateDonut(values, colors) {
    generatePieGraph('donutCanvas', {
        values: values,
        colors: colors,
        animation: true,
        animationSpeed: 2,
        doughnutHoleSize: null,
        doughnutHoleColor: '#fff',
        offset: 0,
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
}