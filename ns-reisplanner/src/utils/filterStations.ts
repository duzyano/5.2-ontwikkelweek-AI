export const filterStations = (stations: string[], input: string, exclude = ''): string[] => {
  if (!input || input.length < 2) return [];
  return stations
    .filter(s => s.toLowerCase().includes(input.toLowerCase()) && s !== exclude)
    .slice(0, 8);
};
