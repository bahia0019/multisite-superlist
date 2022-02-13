import { render, screen } from '@testing-library/react';
import Sitelist from './Sitelist';

test('renders learn react link', () => {
  render(<Sitelist />);
  const linkElement = screen.getByText(/learn react/i);
  expect(linkElement).toBeInTheDocument();
});
